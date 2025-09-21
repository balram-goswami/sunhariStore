<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductShippingZoneResource\Pages;
use App\Filament\Resources\ProductShippingZoneResource\RelationManagers;
use App\Filament\Resources\ProductShippingZoneResource\RelationManagers\MethodsRelationManager;
use App\Filament\Resources\ProductShippingZoneResource\RelationManagers\RegionsRelationManager;
use App\Models\ProductShippingZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Session;

class ProductShippingZoneResource extends Resource
{
    protected static ?string $navigationGroup = 'Orders';
    protected static ?int $navigationSort = 5;
    protected static ?string $model = ProductShippingZone::class;
    protected static ?string $navigationLabel = 'Shipping Zones';
    protected static ?string $pluralModelLabel = 'Shipping Zones';
    protected static ?string $modelLabel = 'Shipping Zone';

    protected static ?string $navigationIcon = 'heroicon-o-map';

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
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->hasRole(UserRoles::Admin)) {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            })
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            RegionsRelationManager::class,
            MethodsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductShippingZones::route('/'),
            //'create' => Pages\CreateProductShippingZone::route('/create'),
            // 'edit' => Pages\EditProductShippingZone::route('/{record}/edit'),
        ];
    }
}
