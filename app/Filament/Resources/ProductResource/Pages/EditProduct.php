<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use App\Models\ProductVariation;
use App\Models\Enums\ProductStatus;
use Filament\Notifications\Notification;


class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    // protected function beforeSave(): void
    // {
    //     $record = $this->record;
    //     $data = $this->form->getState();

    //     if (empty($data['product_attributes']) || count($data['product_attributes']) === 0) {
    //         Notification::make()
    //             ->title('Warning')
    //             ->body('Please review before saving!')
    //             ->danger()
    //             ->send();

    //         // throw new \Exception('Please Check variations before saving.');
    //     } else {
    //         Notification::make()
    //             ->title('Product Saved')
    //             ->body('Product variations have been reviewed.')
    //             ->success()
    //             ->send();
    //     }
    // }
    
    protected function getSavedNotification(): ?Notification
    {
        $status = $this->record->status; // Enum object

        return match ($status) {
            ProductStatus::Draft =>
            Notification::make()
                ->title('⚠️ Product saved as Draft')
                ->body('This product is in Draft mode and will not be visible to users until published.')
                ->danger(),

            ProductStatus::Obsolete =>
            Notification::make()
                ->title('🗑️ Product saved as Obsolete')
                ->body('This product is marked as Obsolete and will not be visible to users.')
                ->warning(),

            // ProductStatus::Publish =>
            // Notification::make()
            //     ->title('✅ Product published successfully')
            //     ->success(),

            default =>
            Notification::make()
                ->title('Product saved')
                ->success(),
        };
    }

    protected function afterSave(): void
    {
        $data   = $this->form->getState();
        $record = $this->record;

        ProductVariation::where('product_id', $record->id)->delete();
        $product_variants = $data['variations']['product_variations'] ?? [];

        if ($product_variants) {
            $items = [];
            foreach ($product_variants as $product_variant) {
                if ($product_variant['is_deleted']) {
                    continue;
                }
                if ($product_variant['is_outdated']) {
                    continue;
                }
                $items[] = [
                    'product_id' => $record->id,
                    'pair_id' => $product_variant['pair_id'],
                    'label' => $product_variant['label'],
                    'sku' => $product_variant['sku'],
                    'attributes' => json_encode($product_variant['attributes']),
                    'dimensions' => json_encode($product_variant['dimensions']),
                    'price' => $product_variant['price'],
                    'sale_price' => $product_variant['sale_price'],
                    'stock' => $product_variant['stock'],
                    'weight' => $product_variant['weight'],
                    'is_available' => $product_variant['is_available'] ? true : false,
                    'attribute_count' => $product_variant['attribute_count'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            ProductVariation::insert($items);
        }
    }

    public function removeVariant(int $index): void
    {
        $currentVariations = $this->data['variations']['product_variations'] ?? [];

        if (!isset($currentVariations[$index])) {
            return;
        }
        $currentVariations[$index]['is_deleted'] = true;
        $currentVariations[$index]['is_available'] = false;
        $currentVariations = array_values($currentVariations); // Re-index array
        $this->data['variations']['product_variations'] = $currentVariations;
    }

    public function updateVariation(int $index, string $name, numeric|string $value): void
    {
        $variations = $this->data['variations']['product_variations'];
        $inputNames = [
            'sku',
            'price',
            'sale_price',
            'stock',
            'is_available',
        ];

        if (!in_array($name, $inputNames)) {
            return;
        }
        if ($name == 'price' &&  is_numeric($value)) {
            $variations[$index]['price'] = $value;
        }
        if ($name == 'sale_price' &&  is_numeric($value) && $value < $variations[$index]['price']) {
            $variations[$index]['sale_price'] = $value;
        } else {
            $variations[$index]['sale_price'] = 0;
        }
        if ($name == 'stock' &&  is_numeric($value)) {
            $variations[$index]['stock'] = $value;
        }
        if ($name == 'is_available' &&  is_bool($value)) {
            $variations[$index]['is_available'] = $value;
        }
        $variations[$index]['is_edited'] = true;
        $this->data['variations']['product_variations'] = $variations;
    }
}
