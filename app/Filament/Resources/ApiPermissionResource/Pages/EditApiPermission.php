<?php

namespace App\Filament\Resources\ApiPermissionResource\Pages;

use App\Filament\Resources\ApiPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApiPermission extends EditRecord
{
    protected static string $resource = ApiPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
