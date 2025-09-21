<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;


class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
            Actions\DeleteAction::make(),
        ];
    }
}
