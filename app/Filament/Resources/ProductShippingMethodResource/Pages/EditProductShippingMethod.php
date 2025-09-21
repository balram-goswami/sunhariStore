<?php

namespace App\Filament\Resources\ProductShippingMethodResource\Pages;

use App\Filament\Resources\ProductShippingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductShippingMethod extends EditRecord
{
    protected static string $resource = ProductShippingMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
