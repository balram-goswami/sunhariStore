<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QueryResource\Pages;
use App\Filament\Resources\QueryResource\RelationManagers;
use App\Models\Query;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Enums\UserRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QueryResource extends Resource
{
    protected static ?string $model = Query::class;

    protected static ?string $navigationGroup = 'Help Section';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Contact Us Form';
    protected static ?string $modelLabel = 'Contact Us Form';
    protected static ?string $pluralModelLabel = 'Contact Us Forms';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';


    

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        $query = static::getModel()::query();

        if ($tenantId = Session::get('tenant_id')) {
            $query->where('domain_id', (string) $tenantId);
        }

        if ($user->hasRole(UserRoles::Admin)) {
            return $query->count();
        }

        return $query->where('user_id', $user->id)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                Tables\Columns\TextColumn::make('query_type')->label('Form')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Query Message')->sortable()->searchable(),
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
            'index' => Pages\ListQueries::route('/'),
            'create' => Pages\CreateQuery::route('/create'),
            'edit' => Pages\EditQuery::route('/{record}/edit'),
        ];
    }
}
