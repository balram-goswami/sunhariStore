<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;
use Illuminate\Support\Facades\Session;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationGroup = 'Help Section';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    

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
        return $form->schema([
            Forms\Components\Hidden::make('user_id')->default(Auth::id()),

            Forms\Components\TextInput::make('subject')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('message')
                ->required()
                ->rows(5),

            Forms\Components\Textarea::make('response')
                ->required()
                ->rows(5),

            Forms\Components\Select::make('status')
                ->options([
                    'open' => 'Open',
                    'in_progress' => 'In Progress',
                    'resolved' => 'Resolved',
                    'closed' => 'Closed',
                ])
                ->default('open')
                ->disabled(fn($livewire) => !auth()->user()->hasRole(UserRoles::Admin)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('subject')->label('Subject')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Message')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('response')->label('Responce')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->hasRole(UserRoles::Admin)) {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            })
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
