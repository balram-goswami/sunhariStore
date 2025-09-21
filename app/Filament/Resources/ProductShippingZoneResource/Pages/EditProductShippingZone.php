<?php

namespace App\Filament\Resources\ProductShippingZoneResource\Pages;

use App\Filament\Resources\ProductShippingZoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductShippingZone extends EditRecord
{
    protected static string $resource = ProductShippingZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
