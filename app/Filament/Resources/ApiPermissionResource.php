<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiPermissionResource\Pages;
use App\Models\ApiPermission;
use App\Models\Enums\UserRoles;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\MultiSelect;

class ApiPermissionResource extends Resource
{
    protected static ?string $model = ApiPermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole(UserRoles::Admin);
    }
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\MultiSelect::make('permissions')
                    ->label('API Permissions')
                    ->options(
                        Permission::where('name', 'like', 'api:%')->pluck('name', 'name')
                    )
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('permissions')
                    ->label('Permissions')
                    ->formatStateUsing(function ($state) {
                        return implode(', ', $state ?? []);
                    })
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListApiPermissions::route('/'),
            'create' => Pages\CreateApiPermission::route('/create'),
            'edit' => Pages\EditApiPermission::route('/{record}/edit'),
        ];
    }
}
