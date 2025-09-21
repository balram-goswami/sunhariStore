<?php

namespace App\Filament\Clusters\WebContent\Resources\PageResource\Pages;

use App\Filament\Clusters\WebContent\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
