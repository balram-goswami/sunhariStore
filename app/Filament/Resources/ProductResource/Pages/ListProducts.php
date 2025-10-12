<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public bool $showObsolete = false;


    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggleObsolete')
                ->label(fn() => $this->showObsolete ? 'Show All' : 'Show Obsolete')
                ->icon('heroicon-o-archive-box')
                ->color(fn() => $this->showObsolete ? 'success' : 'warning')
                ->action(fn() => $this->showObsolete = ! $this->showObsolete),

            Actions\CreateAction::make(),

            Actions\Action::make('exportToGoogleSheet')
                ->label('Export to Google Sheet')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    // Call your controller method
                    $controller = app(\App\Http\Controllers\Front\GoogleSheetExportController::class);
                    $response = $controller->export();
                    $data = json_decode($response->getContent(), true);

                    if (isset($data['message'])) {
                        Notification::make()
                            ->title($data['message'])
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title($data['error'] ?? 'Export failed')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
