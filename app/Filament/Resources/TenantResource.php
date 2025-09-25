<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Models\Enums\TenantStatus;
use App\Models\Tenant;
use App\Services\VerifyDomainService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\View;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\UserRoles;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('domain')->required()
                    ->helperText('Point your domain to yourserver.com using a CNAME record.'),

                View::make('livewire.verify-dns-instruction')
                    ->visible(fn(?Tenant $record) => $record !== null)
                    ->viewData(['record' => Tenant::find(request()->route('record'))])
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                $domainId = session('domain_id');

                if ($user->hasRole(UserRoles::Admin)) {
                    return $query->when($domainId, fn($q) => $q->where('domain_id', $domainId));
                }

                return $query->where('user_id', $user->id)
                    ->when($domainId, fn($q) => $q->where('domain_id', $domainId));
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('domain')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('is_verified')
                    ->label('Status')->badge()
                    ->formatStateUsing(fn($state) => TenantStatus::from((int)$state)->label())
                    ->color(fn($state) => TenantStatus::from((int)$state)->color()),
            ])
            ->filters([
                SelectFilter::make('status')->attribute('is_verified')
                    ->options(
                        collect(TenantStatus::cases())
                            ->mapWithKeys(fn(TenantStatus $status) => [$status->value => $status->label()])
                            ->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('settings')
                    ->label('Settings')
                    ->url(function (Tenant $record) {
                        $settings = $record->settings;
                        if ($settings) {
                            return \App\Filament\Resources\TenantSettingResource::getUrl('edit', ['record' => $settings->id]);
                        }
                        return \App\Filament\Resources\TenantSettingResource::getUrl('create', ['domain_id' => $record->id]);
                    })
                    ->icon('heroicon-o-cog')
                    ->color('primary'),

                Action::make('preview')
                    ->label('Preview')
                    ->url(fn(Tenant $record) => !$record->is_verified ? 'http://' . $record->domain : null)
                    ->visible(fn(Tenant $record) => !$record->is_verified)
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->openUrlInNewTab(),

                Action::make('verifyDns')
                    ->label('Verify Domain')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Tenant $record) => !$record->is_verified)
                    ->requiresConfirmation()
                    ->action(function (Tenant $record): void {
                        $result = app()->call([new VerifyDomainService(), 'verifyDNS'], ['tenant' => $record]);

                        if ($result) {
                            Notification::make()
                                ->title('Domain verified!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Verification Pending')
                                ->body('Verification failed. Make sure DNS CNAME record is correct.')
                                ->danger()
                                ->send();
                        }
                    }),

                // Action::make('openDomain')
                //     ->label('Open Domain')
                //     ->icon('heroicon-o-globe-alt')
                //     ->url(fn(Tenant $record) => $record->getDashboardUrl())
                //     ->color('secondary'),
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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
