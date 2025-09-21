<?php

namespace App\Filament\Resources\ProductBrandResource\Pages;

use App\Filament\Resources\ProductBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProductBrand extends CreateRecord
{
    protected static string $resource = ProductBrandResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $auth = Auth::id();
        $data['user_id'] = $auth;

        return $data;
    }
}
