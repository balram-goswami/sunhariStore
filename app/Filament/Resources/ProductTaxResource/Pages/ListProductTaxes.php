<?php

namespace App\Filament\Resources\ProductTaxResource\Pages;

use App\Filament\Resources\ProductTaxResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductTaxes extends ListRecords
{
    protected static string $resource = ProductTaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
