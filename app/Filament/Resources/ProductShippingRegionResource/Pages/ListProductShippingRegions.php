<?php

namespace App\Filament\Resources\ProductShippingRegionResource\Pages;

use App\Filament\Resources\ProductShippingRegionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductShippingRegions extends ListRecords
{
    protected static string $resource = ProductShippingRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
