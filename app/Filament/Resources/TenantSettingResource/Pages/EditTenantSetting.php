<?php

namespace App\Filament\Resources\TenantSettingResource\Pages;

use App\Filament\Resources\TenantSettingResource;
use App\Models\TenantSetting;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditTenantSetting extends EditRecord
{
    protected static string $resource = TenantSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('settings')
                    ->label('Settings')
                    ->url(function (TenantSetting $record) {
                        if ($record) {
                            return \App\Filament\Resources\TenantResource::getUrl('edit', ['record' => $record->tenant_id]);
                        }
                    })
                    ->icon('heroicon-o-cog')
                    ->color('primary'),
            Actions\DeleteAction::make(),
        ];
    }
}
