<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductShippingMethodResource\Pages;
use App\Filament\Resources\ProductShippingMethodResource\RelationManagers;
use App\Models\ProductShippingMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Enums\UserRoles;
use Illuminate\Support\Facades\Session;

class ProductShippingMethodResource extends Resource
{
    protected static ?string $model = ProductShippingMethod::class;

    protected static ?string $navigationGroup = 'Orders';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Shipping Method';
    protected static ?string $pluralModelLabel = 'Shipping Method';
    protected static ?string $modelLabel = 'Shipping Method';

    // public static function getNavigationBadge(): ?string
    // {
    //     $user = Auth::user();

    //     if ($user->hasRole(UserRoles::Admin)) {
    //         return static::getModel()::count();
    //     }

    //     return static::getModel()::where('user_id', $user->id)->count();
    // }

    

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                Forms\Components\TextInput::make('name')->required()->columnSpanFull(),
                Forms\Components\Textarea::make('about')->rows(2)->required()->columnSpanFull(),
                Forms\Components\TextInput::make('deliver')->numeric()->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'flat' => 'Flat Rate',
                        'free' => 'Free Shipping',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('tax')->required(),
                Forms\Components\TextInput::make('min_amount')->numeric()->default(0),
                Forms\Components\TextInput::make('discount')->numeric()->required(),

                Forms\Components\Select::make('zone_id')
                    ->label('Shipping Zone')
                    ->relationship('zone', 'name')
                    ->required(),
                Forms\Components\Toggle::make('status')->label('Active')->default(true)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->modifyQueryUsing(function (Builder $query) {
            //     return $query->where('user_id', Auth::id());
            // })
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                \Filament\Tables\Columns\TextColumn::make('type')->sortable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('tax'),
                \Filament\Tables\Columns\TextColumn::make('min_amount'),
                \Filament\Tables\Columns\TextColumn::make('zone.name')->label('Zone')->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProductShippingMethods::route('/'),
            // 'create' => Pages\CreateProductShippingMethod::route('/create'),
            // 'edit' => Pages\EditProductShippingMethod::route('/{record}/edit'),
        ];
    }
}
