<?php

namespace App\Filament\Resources\ProductResource;

use App\Forms\Components\VariantTable;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Filament\Forms;
use Illuminate\Support\Str;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Session;

class ProductSelectAttributeVariants
{
    public static function make(): array
    {
        return [

            Forms\Components\Hidden::make('variations')->default([
                'product_variations' => [],
                'previous_variations' => [],
            ]),

            Forms\Components\Actions::make([
                Forms\Components\Actions\Action::make('generate_variants')
                    ->label('Generate Variants')
                    ->color('primary')
                    ->action(function ($get, $set, $livewire) {
                        self::generateCombinations($get, $set, $livewire);

                        $livewire->dispatch('$refresh');
                    })
                    ->visible(fn($get) => !empty($get('product_attributes'))),
            ])->columnSpanFull(),

            Forms\Components\View::make('forms.components.variant-table-livewire')
                ->columnSpanFull()
                ->viewData(function ($get, $livewire) {
                    return [
                        'variations' => $get('variations')['product_variations'] ?? [],
                        'livewire' => $livewire
                    ];
                })->afterStateHydrated(function ($state, $set, $get, $livewire) {
                    $product = $livewire->getRecord();
                    if ($product && $product->has_variants) {
                        $variations = ProductVariation::where('product_id', $product->id)->get();
                        if ($variations->count()) {
                            $variations = $variations->toArray();
                            $set('variations.product_variations', $variations);
                        }
                    }
                }),
        ];
    }

    private static function autoSKU(string $baseSku, array $attributes = []): string
    {
        $sku = Str::upper(Str::slug($baseSku, '-'));

        if (!empty($attributes)) {
            foreach ($attributes as $attr) {
                $sku .= '-' . Str::upper(Str::slug($attr, '-'));
            }
        }
        return $sku;
    }

    private static function generateCombinations($get, $set, $livewire = null)
    {
        $attributesRows = $get('product_attributes') ?? [];
        $previousVariations = $get('variations')['previous_variations'] ?? [];

        if (empty($attributesRows))
            return;

        $edited = $get('variations')['product_variations'] ?? [];

        // Filter valid attributes
        $validAttributes = array_filter($attributesRows, fn($a) => !empty($a['attribute_id']) && !empty($a['attribute_value_id']));
        if (empty($validAttributes))
            return;

        $attributeIds = collect($validAttributes)->pluck('attribute_id')->toArray();
        $attributeValueIds = collect($validAttributes)->pluck('attribute_value_id')->flatten()->toArray();

        $attributeData = Attribute::with(['values' => function ($query) use ($attributeValueIds) {
            $query->select('id', 'value', 'attribute_id');
            $query->whereIn('id', $attributeValueIds);
        }])
            ->select('id', 'name')
            ->whereIn('id', $attributeIds)
            ->get();

        $product_attribute_count = $attributeData->count();

        self::setOutdatedVariants(
            $edited,
            $product_attribute_count,
            $set
        );  // outdated variants

        $editedVariants = self::editedVariants($edited);  // edited variants

        $deletedVariants = self::deletedVariants($edited);  // deleted variants
        [$signature, $combinations] = self::cartesianProduct($attributeData);  // new combinations variants

        $newVariants = self::formFieldsData($combinations, $get);

        // Merge new combinations with existing edited variants
        $allVariants = self::mergeVariants($newVariants, $editedVariants, $deletedVariants);

        $set('variations.product_variations', array_values($allVariants));

        $set('variations.previous_variations', [
            'variations' => array_values($allVariants),
            'signature' => $signature,
        ]);
        return;
    }

    private static function mergeVariants(array $newVariants, array $editedVariants, array $deletedVariants): array
    {
        $editedPairIds = array_column($editedVariants, 'pair_id');
        $deletedPairIds = array_column($deletedVariants, 'pair_id');

        $filteredNew = array_filter($newVariants, function ($variant) use ($editedPairIds, $deletedPairIds) {
            return !in_array($variant['pair_id'], $deletedPairIds, true) && !in_array($variant['pair_id'], $editedPairIds, true);
        });
        return array_values(array_merge($editedVariants, $filteredNew));
    }

    private static function setOutdatedVariants(&$editedVariants, $product_attribute_count, $set): void
    {
        foreach ($editedVariants as &$variant) {
            if ($variant['attribute_count'] != $product_attribute_count) {
                $variant['is_outdated'] = true;
            }
        }
        $set('variations.product_variations', array_values($editedVariants));
        return;
    }

    private static function deletedVariants($editedVariants): array
    {
        $filteredEditedVariants = array_values(array_filter($editedVariants, function ($variant) {
            return !empty($variant['is_deleted']);
        }));
        return $filteredEditedVariants;
    }

    private static function editedVariants($edited): array
    {
        $filteredEditedVariants = array_values(array_filter($edited, function ($variant) {
            return !empty($variant['is_edited']);
        }));
        return $filteredEditedVariants;
    }

    private static function formFieldsData($combinations, $get)
    {
        $final = [];
        foreach ($combinations as $combo) {
            // Base SKU (product ka main SKU)
            $baseSku = $get('sku') ?? 'PRODUCT';

            // Variant attributes ko nikalna (color, size, etc.)
            $attributes = $combo['attributes'] ?? [];

            // Auto SKU generate karna
            $variantSku = self::autoSKU($baseSku, $attributes);

            $final[] = [
                'id' => null,
                'pair_id' => $combo['pair_id'],
                'label' => $combo['label'],
                'sku' => $variantSku,
                'attributes' => $attributes,
                'price' => $get('price') ?? 0,
                'sale_price' => $get('sale_price') ?? null,
                'stock' => $get('qty') ?? 0,
                'weight' => null,
                'dimensions' => [
                    'length' => null,
                    'width' => null,
                    'height' => null,
                ],
                'attribute_count' => $combo['attribute_count'],
                'is_available' => true,
                'is_outdated' => false,
                'is_deleted' => false,
                'is_edited' => false,
            ];
        }
        return $final;
    }


    private static function cartesianProduct(\Illuminate\Support\Collection|array $attributes): array
    {
        $results = [[]];
        if ($attributes->isEmpty()) {
            return [];
        }

        foreach ($attributes as $attribute) {
            $newResults = [];

            foreach ($results as $result) {
                $pair_id = [];
                foreach ($attribute['values'] as $value) {
                    $pair_id[] = $attribute['id'] . '-' . $value['id'];
                    $newResults[] = array_merge($result, [[
                        'attribute_id' => $attribute['id'],
                        'attribute_name' => $attribute['name'],
                        'value_id' => $value['id'],
                        'value' => $value['value'],
                    ]]);
                }
            }
            $results = $newResults;
        }

        // Build final array with combination, label, and frontend-friendly attribute map
        $combinations = array_map(function ($combination) {
            $attributesMap = [];
            $pairs = [];
            foreach ($combination as $item) {
                // Use lowercase keys for frontend-friendly mapping
                $attributesMap[strtolower($item['attribute_name'])] = $item['value'];
                $pairs[] = $item['attribute_id'] . '-' . $item['value_id'];
            }

            sort($pairs);
            $pair_id = implode('-', $pairs);

            return [
                'pair_id' => md5($pair_id),
                'combination' => $combination,
                'label' => implode(' / ', array_column($combination, 'value')),
                'attributes' => $attributesMap,
                'attribute_count' => count($combination),
            ];
        }, $results);
        return [$results, $combinations];
    }
}
