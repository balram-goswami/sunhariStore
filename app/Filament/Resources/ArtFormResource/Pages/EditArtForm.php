<?php

namespace App\Filament\Resources\ArtFormResource\Pages;

use App\Filament\Resources\ArtFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtForm extends EditRecord
{
    protected static string $resource = ArtFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
