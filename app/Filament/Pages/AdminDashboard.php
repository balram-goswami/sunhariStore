<?php

namespace App\Filament\Pages;

use App\Models\Enums\UserRoles;
use Filament\Pages\Page;

use Illuminate\Support\Facades\Auth;

use App\Models\{
    Product,
    Order,
    ProductBrand,
    Customer,
    Tenant,
    User
};

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.admin-dashboard';
    protected static ?string $navigationGroup = null;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole(UserRoles::Admin);
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    protected function getViewData(): array
    {
        return [
            'user'          => $this->user,
            'productCount'  => Product::all()->count(),
            'orderCount'    => Order::all()->count(),
            'brandCount'    => ProductBrand::all()->count(),
            'userCount'     => User::where('role', 2)->count(),
        ];
    }
}
