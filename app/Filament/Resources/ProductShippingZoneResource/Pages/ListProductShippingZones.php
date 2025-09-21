<?php

namespace App\Filament\Resources\ProductShippingZoneResource\Pages;

use App\Filament\Resources\ProductShippingZoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductShippingZones extends ListRecords
{
    protected static string $resource = ProductShippingZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
