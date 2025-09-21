<?php

namespace App\Filament\Pages;

use App\Models\Enums\UserRoles;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static string $view = 'filament.pages.dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Remove Dashboard from side menu
    }

    public function mount(): void
    {
        $user = Auth::user();

        if ($user->hasRole(UserRoles::Admin)) {
            $this->redirectRoute('filament.pages.admin-dashboard');
        } elseif ($user->hasRole(UserRoles::Manager)) {
            $this->redirectRoute('filament.pages.vendor-dashboard');
        } else {
            abort(403);
        }
    }
}
