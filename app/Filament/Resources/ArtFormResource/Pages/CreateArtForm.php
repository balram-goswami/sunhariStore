<?php

namespace App\Filament\Resources\ArtFormResource\Pages;

use App\Filament\Resources\ArtFormResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateArtForm extends CreateRecord
{
    protected static string $resource = ArtFormResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Request Submitted')
            ->body('Your request was submitted successfully. Admin will review it shortly.')
            ->success()
            ->send();
    }
}
