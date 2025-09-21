<?php

namespace App\Filament\Resources\ArtFormResource\Pages;

use App\Filament\Resources\ArtFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtForms extends ListRecords
{
    protected static string $resource = ArtFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
