<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Mail\UserWelcomeMail;
use App\Models\Enums\UserRoles;
use App\Models\Enums\UserStatus;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static array $commissionData = [];
    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(UserRoles::Admin);
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        static::$commissionData = $data['commission_data'] ?? [];

        unset($data['commission_data']);
        return $data;
    }

    protected static function mutateFormDataBeforeUpdate(array $data): array
    {
        static::$commissionData = $data['commission_data'] ?? [];

        unset($data['commission_data']);
        return $data;
    }

    protected static function afterCreate(Model $record, array $data): void
    {
        $record->commission()->updateOrCreate(
            ['user_id' => $record->id],
            static::$commissionData
        );

        Mail::to($record->email)->send(new UserWelcomeMail($record));

        static::$commissionData = [];
    }

    protected static function afterUpdate(Model $record, array $data): void
    {
        $record->commission()->updateOrCreate(
            ['user_id' => $record->id],
            static::$commissionData
        );

        static::$commissionData = [];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->required()
                ->email(),

            FileUpload::make('profile_photo_path')->avatar(),

            Forms\Components\Select::make('role')
                ->label('Role')
                ->required()
                ->options(
                    collect(UserRoles::cases())
                        ->mapWithKeys(fn(UserRoles $role) => [$role->value => $role->label()])
                        ->toArray()
                ),

            Forms\Components\TextInput::make('password')
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                ->dehydrated(fn($state) => filled($state))
                ->label('Password'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn(UserRoles $state) => $state->label()),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(
                        collect(UserStatus::cases())
                            ->mapWithKeys(fn(UserStatus $status) => [$status->value => $status->label()])
                            ->toArray()
                    ),
                SelectFilter::make('role')
                    ->label('Role')
                    ->options(
                        collect(UserRoles::cases())
                            ->mapWithKeys(fn(UserRoles $role) => [$role->value => $role->label()])
                            ->toArray()
                    ),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
