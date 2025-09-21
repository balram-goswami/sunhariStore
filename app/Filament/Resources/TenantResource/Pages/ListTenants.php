<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions; // this gives us CreateAction
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles; // adjust namespace if needed

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();

        if ($user && $user->hasRole(UserRoles::Admin)) {
            return [];
        }

        return [
            Actions\CreateAction::make(),
        ];
    }
}
