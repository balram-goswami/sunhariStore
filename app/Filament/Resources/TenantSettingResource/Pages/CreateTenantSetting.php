<?php

namespace App\Filament\Resources\TenantSettingResource\Pages;

use App\Filament\Resources\TenantSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTenantSetting extends CreateRecord
{
    protected static string $resource = TenantSettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! auth()->user()->tenants()->where('id', $data['domain_id'])->exists()) {
            abort(403);
        }
       // dd($data);
        
        $data['tenant_id'] = $data['domain_id'];
        unset($data['domain_id']);
        
        return $data;
    }
}
