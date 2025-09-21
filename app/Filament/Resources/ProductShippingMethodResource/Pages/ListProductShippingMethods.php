<?php

namespace App\Filament\Resources\ProductShippingMethodResource\Pages;

use App\Filament\Resources\ProductShippingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductShippingMethods extends ListRecords
{
    protected static string $resource = ProductShippingMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
