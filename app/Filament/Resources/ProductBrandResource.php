<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductBrandResource\Pages;
use App\Filament\Resources\ProductBrandResource\RelationManagers;
use App\Models\ProductBrand;
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
use App\Models\Tenant;

class ProductBrandResource extends Resource
{
    protected static ?string $model = ProductBrand::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Products';
    protected static ?string $navigationLabel = 'Material Type';
    protected static ?int $navigationSort = 2;

    

    // public static function getNavigationBadge(): ?string
    // {
    //     $user = Auth::user();
    //     $query = static::getModel()::query();

    //     if ($tenantId = Session::get('tenant_id')) {
    //         $query->where('domain_id', (string) $tenantId);
    //     }

    //     if ($user->hasRole(UserRoles::Admin)) {
    //         return $query->count();
    //     }

    //     return $query->where('user_id', $user->id)->count();
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->unique()
                    ->required()->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->directory('products_brands')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public') 
                    ->size(50),
                \Filament\Tables\Columns\TextColumn::make('name')->searchable(),
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
            'index' => Pages\ListProductBrands::route('/'),
            // 'create' => Pages\CreateProductBrand::route('/create'),
            // 'edit' => Pages\EditProductBrand::route('/{record}/edit'),
        ];
    }
}
