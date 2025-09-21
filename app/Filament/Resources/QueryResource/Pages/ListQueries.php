<?php

namespace App\Filament\Resources\QueryResource\Pages;

use App\Filament\Resources\QueryResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;

class ListQueries extends ListRecords
{
    protected static string $resource = QueryResource::class;

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
