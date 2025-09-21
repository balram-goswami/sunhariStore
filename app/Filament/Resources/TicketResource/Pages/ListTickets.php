<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();

        if ($user && ($user->hasRole(UserRoles::Admin) || $user->hasRole(UserRoles::Manager))) {
            return [];
        }

        return [
            Actions\CreateAction::make(),
        ];
    }
}
