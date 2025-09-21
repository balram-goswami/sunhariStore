<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Enums\UserRoles;
use App\Filament\Resources\AttributeResource\AttributeForm as AttributeFormComponent;
use Illuminate\Support\Facades\Session;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationGroup = 'Products';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    

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
            ->schema(AttributeFormComponent::make())->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('values.value')->searchable(),
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
            'index' => Pages\ListAttributes::route('/'),
            // 'create' => Pages\CreateAttribute::route('/create'),
            // 'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
