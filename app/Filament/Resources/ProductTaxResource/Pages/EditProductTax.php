<?php

namespace App\Filament\Resources\ProductTaxResource\Pages;

use App\Filament\Resources\ProductTaxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductTax extends EditRecord
{
    protected static string $resource = ProductTaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
