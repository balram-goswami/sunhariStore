<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTaxResource\Pages;
use App\Filament\Resources\ProductTaxResource\RelationManagers;
use App\Models\ProductTax;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\CreateAction;
use App\Models\Enums\UserRoles;
use Illuminate\Support\Facades\Session;

class ProductTaxResource extends Resource
{
    protected static ?string $model = ProductTax::class;

    protected static ?string $navigationGroup = 'Products';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

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

                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('rate')
                    ->label('Rate')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('rate_type')
                    ->label('Rate Type')
                    ->required()
                    ->options([
                        'fixed' => 'Fixed',
                        'percentage' => 'Percentage',
                    ])
                    ->native(false),

            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                \Filament\Tables\Columns\TextColumn::make('rate'),
                \Filament\Tables\Columns\TextColumn::make('rate_type'),
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
            'index' => Pages\ListProductTaxes::route('/'),
            // 'create' => Pages\CreateProductTax::route('/create'),
            //'edit' => Pages\EditProductTax::route('/{record}/edit'),
        ];
    }
}
