<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\ProductAttributeVariants as ProductAttributeVariantsComponent;
use App\Filament\Resources\ProductResource\ProductSelectAttributeVariants as ProductSelectAttributeVariantsComponent;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Enums\ProductFeaturedStatus;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\UserRoles;
use App\Models\Tenant;
use App\Models\ProductCategory;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?string $navigationIcon = 'heroicon-o-cube';



    public static function form(Form $form): Form
    {
        $productRecord = $form->getRecord();
        return $form
            ->schema([
                Split::make([
                    Grid::make([
                        'default' => 1,
                    ])->schema([
                        Section::make('Product Detail')
                            ->description('The items you have selected for purchase')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'This name will be visible to customers.'),

                                Forms\Components\RichEditor::make('description')
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                    ])
                                    ->rule('max_words:2000')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Full product description with details.'),

                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Short description')
                                    ->rows(3)
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'A short summary that shows in listings.')
                                    ->rule('max_words:20'),

                                Forms\Components\KeyValue::make('spec')
                                    ->label('Specification')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Add technical or product specifications.'),
                            ])
                            ->collapsible(),

                        Section::make('Pricing')->schema([
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->default(fn() => 'SUNHARI-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT))
                                    ->readOnly(),
                                Split::make([
                                    Forms\Components\TextInput::make('price')->label('Regular Price')->default(0)->numeric()->required(),

                                    Forms\Components\TextInput::make('sale_price')->label('Sale Price')->default(0)->numeric(),
                                ]),
                                Forms\Components\TextInput::make('qty')->label('Stock')->default(0)->numeric(),
                            ]),
                        ])->collapsible(),

                        Section::make('Product Attributes and Variants')
                            ->schema([

                                Toggle::make('has_variants')
                                    ->label('Has Variants')
                                    ->reactive()
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Enable if this product has size, color, etc.'),

                                Tabs::make('Tabs')
                                    ->tabs([
                                        Tabs\Tab::make('Attributes')
                                            ->schema(ProductAttributeVariantsComponent::make())->extraAttributes(['style' => 'padding: 4px;']),
                                        Tabs\Tab::make('Variants')
                                            ->schema(ProductSelectAttributeVariantsComponent::make($productRecord))->extraAttributes(['style' => 'padding: 4px;']),
                                    ])->visible(fn($get) => $get('has_variants')),

                            ])
                            ->collapsible(),

                        Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Search-Engine-Optimization Title.'),
                                Forms\Components\TextInput::make('seo_keywords')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Keywords separated by commas.'),
                                Forms\Components\TextInput::make('seo_desc')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Meta description for search engines.'),
                            ])
                            ->collapsible(),
                    ]),

                    Section::make([


                        Select::make('brand_id')
                            ->label('Fabric Used')
                            ->relationship('brand', 'name', function ($query) {
                                $query->where('domain_id', Session::get('tenant_id'));
                            })
                            ->preload()
                            ->searchable()
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Select associated brand.'),

                        Select::make('category_id')
                            ->label('Category')
                            ->multiple()
                            ->relationship('category', 'name', function ($query) {
                                $query->where('domain_id', Session::get('tenant_id'));
                            })
                            ->preload()
                            ->searchable()
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Select product category.'),

                        Select::make('status')
                            ->label('Status')
                            ->options(
                                collect(ProductStatus::cases())
                                    ->mapWithKeys(fn(ProductStatus $status) => [$status->value => $status->label()])
                                    ->toArray()
                            )
                            ->default(ProductStatus::Draft->value)
                            ->disablePlaceholderSelection()
                            ->hintIcon(
                                'heroicon-m-question-mark-circle',
                                tooltip: 'Draft: hidden, Published: visible.'
                            ),

                        Select::make('taxable')
                            ->options([
                                'taxable' => 'Taxable',
                                'shipping' => 'Shipping only',
                                'none' => 'None',
                            ])
                            ->default('none')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Choose tax settings.'),

                        Toggle::make('featured')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Mark as featured to highlight product.'),

                        TagsInput::make('tag')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Add tags for search and filtering.'),

                        Forms\Components\FileUpload::make('image')
                            ->directory('products')
                            ->multiple()
                            ->maxParallelUploads(5)
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Upload main product images.'),

                    ])->grow(false)->extraAttributes([
                        'style' => 'width:350px',
                    ]),
                ])->from('md'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->size(50),

                \Filament\Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('brand.name')->label('Fabric')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('category_names')
                    ->label('Category')
                    ->badge()
                    ->separator(', ')
                    ->getStateUsing(fn($record) => $record->category_names),

                \Filament\Tables\Columns\TextInputColumn::make('qty')
                    ->label('Stock')
                    ->type('number') // numeric input
                    ->extraInputAttributes([
                        'min'  => 0,
                        'step' => '1',
                    ]) // HTML attributes for the <input>
                    ->rules(['integer', 'min:0']) // Laravel validation
                    ->sortable(),


                \Filament\Tables\Columns\TextColumn::make('variants_count')
                    ->counts('variants')
                    ->label('Variants')
                    ->sortable(),

                \Filament\Tables\Columns\SelectColumn::make('featured')
                    ->label('Featured')
                    ->options(
                        collect(\App\Models\Enums\ProductFeaturedStatus::cases())
                            ->mapWithKeys(fn(\App\Models\Enums\ProductFeaturedStatus $featured) => [
                                $featured->value => $featured->label()
                            ])
                            ->toArray()
                    )
                    ->sortable(),

                \Filament\Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options(
                        collect(ProductStatus::cases())
                            ->mapWithKeys(fn(ProductStatus $status) => [$status->value => $status->label()])
                            ->toArray()
                    )
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->options(
                        collect(ProductStatus::cases())
                            ->mapWithKeys(fn(ProductStatus $status) => [$status->value => $status->label()])
                            ->toArray()
                    ),

                SelectFilter::make('featured')
                    ->options(
                        collect(ProductFeaturedStatus::cases())
                            ->mapWithKeys(fn(ProductFeaturedStatus $status) => [$status->value => $status->label()])
                            ->toArray()
                    ),

                SelectFilter::make('category')
                    ->label('Category')
                    ->options(\App\Models\ProductCategory::pluck('name', 'id'))
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereJsonContains('category_id', [(string) $data['value']]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-check-badge')
                        ->form([
                            \Filament\Forms\Components\Select::make('status')
                                ->label('Status')
                                ->options(
                                    collect(\App\Models\Enums\ProductStatus::cases())
                                        ->mapWithKeys(fn(\App\Models\Enums\ProductStatus $status) => [
                                            $status->value => $status->label()
                                        ])
                                        ->toArray()
                                )
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => $data['status'],
                                ]);
                            }
                        }),

                    Tables\Actions\BulkAction::make('updateFeatured')
                        ->label('Update Featured')
                        ->icon('heroicon-o-star')
                        ->form([
                            \Filament\Forms\Components\Select::make('featured')
                                ->label('Featured')
                                ->options(
                                    collect(\App\Models\Enums\ProductFeaturedStatus::cases())
                                        ->mapWithKeys(fn(\App\Models\Enums\ProductFeaturedStatus $featured) => [
                                            $featured->value => $featured->label()
                                        ])
                                        ->toArray()
                                )
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'featured' => $data['featured'],
                                ]);
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
