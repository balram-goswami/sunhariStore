<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public bool $showObsolete = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggleObsolete')
                ->label(fn () => $this->showObsolete ? 'Show All' : 'Show Obsolete')
                ->icon('heroicon-o-archive-box')
                ->color(fn () => $this->showObsolete ? 'success' : 'warning')
                ->action(fn () => $this->showObsolete = ! $this->showObsolete),

            Actions\CreateAction::make(),
        ];
    }
}
