<?php

namespace App\Filament\Resources\ProductResource;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductAttributeVariants
{
    public static function make()
    {
        return [
            Forms\Components\Repeater::make('product_attributes')
                ->relationship('variantAttributeValues')
                ->label('')
                ->schema([
                    // Attribute select
                    Select::make('attribute_id')
                        ->label('Attribute')
                        ->options(function ($get) {
                            $repeaterState = $get('../../product_attributes') ?? $get('product_attributes') ?? [];

                            // collect all attribute_id values except the one for this row
                            $selectedIds = collect($repeaterState)
                                ->pluck('attribute_id')
                                ->filter()
                                ->reject(fn ($id) => $id == $get('attribute_id'))
                                ->values()
                                ->toArray();

                            return Attribute::query()
                                ->where('domain_id', Session::get('tenant_id', 1))
                                ->whereNotIn('id', $selectedIds)
                                ->pluck('name', 'id')
                                ->toArray();
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set) {
                            // Reset the selected values when attribute changes
                            $set('attribute_value_id', []);
                        })
                        ->createOptionForm(self::attributeForm())
                        ->createOptionUsing(function (array $data, Select $component) {
                            $domainId = Session::get('tenant_id');
                            $user = Auth::user();

                            $existing = Attribute::where('name', $data['name'])
                                ->where('domain_id', $domainId)
                                ->first();

                            if ($existing) {
                                throw \Filament\Forms\Components\SelectOptionCreationException::make(
                                    "Attribute '{$data['name']}' already exists for this domain."
                                );
                            }

                            $attribute = Attribute::create([
                                'name' => $data['name'],
                                'user_id' => $user->id,
                                'domain_id' => $domainId,
                            ]);

                            if (!empty($data['attribute_values'])) {
                                foreach ($data['attribute_values'] as $valueData) {
                                    $attribute->values()->create([
                                        'value' => $valueData['value'],
                                        'domain_id' => $domainId,
                                    ]);
                                }
                            }

                            // Refresh options
                            $component->options(
                                Attribute::query()
                                    ->where('domain_id', $domainId)
                                    ->pluck('name', 'id')
                                    ->toArray()
                            );

                            return $attribute->getKey();
                        }),

                    // Attribute Values select
                    Select::make('attribute_value_id')
                        ->label('Attribute Values')
                        ->multiple()
                        ->options(function ($get) {
                            $attributeId = $get('attribute_id');
                            if (!$attributeId) return [];

                            $attribute = Attribute::with('values')->find($attributeId);
                            if (!$attribute) return [];

                            return $attribute->values->pluck('value', 'id')->toArray();
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->visible(fn ($get) => !empty($get('attribute_id')))
                        ->createOptionForm([
                            Forms\Components\TextInput::make('value')
                                ->label('Value')
                                ->required()
                                ->maxLength(255)
                                ->unique(AttributeValue::class, 'value', ignoreRecord: true),
                        ])
                        ->createOptionUsing(function (array $data, Select $component, $get) {
                            $attributeId = $get('attribute_id');
                            $domainId = Session::get('tenant_id');
                            $attribute = Attribute::where('domain_id', $domainId)->find($attributeId);

                            if (!$attribute || empty($data['value'])) return;

                            $created = $attribute->values()->create([
                                'attribute_id' => $attributeId,
                                'value' => $data['value'],
                            ]);

                            // Refresh options
                            $component->options(
                                $attribute->values()->pluck('value', 'id')->toArray()
                            );

                            return $created->getKey();
                        }),
                ])
                ->defaultItems(0)
                ->minItems(0)
                ->maxItems(100)
                ->addActionLabel('Add Attribute')
                ->addActionAlignment(Alignment::Left)
                ->columns(2)
                ->columnSpanFull()
                ->visible(fn ($get) => $get('has_variants')),
        ];
    }

    private static function attributeForm()
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255)
                ->unique(Attribute::class, 'name', ignoreRecord: true),
            Forms\Components\Repeater::make('attribute_values')
                ->label('Attribute Values')
                ->schema([
                    Forms\Components\TextInput::make('value')
                        ->label('Value')
                        ->required()
                        ->maxLength(255)
                        ->unique(AttributeValue::class, 'value', ignoreRecord: true),
                ])
                ->defaultItems(1)
                ->minItems(1)
                ->maxItems(50)
                ->addActionLabel('Add new Attribute Value')
                ->columns(1),
        ];
    }
}
