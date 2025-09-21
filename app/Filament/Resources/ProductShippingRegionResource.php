<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductShippingRegionResource\Pages;
use App\Filament\Resources\ProductShippingRegionResource\RelationManagers;
use App\Models\ProductShippingRegion;
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

class ProductShippingRegionResource extends Resource
{
    protected static ?string $navigationGroup = 'Orders';
    protected static ?int $navigationSort = 4;
    protected static ?string $model = ProductShippingRegion::class;
    protected static ?string $navigationLabel = 'Shipping Regions';
    protected static ?string $pluralModelLabel = 'Shipping Regions';
    protected static ?string $modelLabel = 'Shipping Region';

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

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
                Forms\Components\TextInput::make('region')->required(),
                Forms\Components\Select::make('zone_id')
                    ->label('Shipping Zone')
                    ->relationship('zone', 'name')
                    ->required(),
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
                \Filament\Tables\Columns\TextColumn::make('region')->sortable()->searchable(),
                \Filament\Tables\Columns\TextColumn::make('zone.name')->sortable()->label('Zone'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductShippingRegions::route('/'),
            // 'create' => Pages\CreateProductShippingRegion::route('/create'),
            // 'edit' => Pages\EditProductShippingRegion::route('/{record}/edit'),
        ];
    }
}
