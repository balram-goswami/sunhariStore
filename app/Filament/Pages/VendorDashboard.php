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
    Tenant
};

class VendorDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.vendor-dashboard';

    protected static ?string $slug = 'dashboard';
    protected static ?string $navigationLabel = 'Manager Dashboard';
    protected static ?string $routeName = 'filament.pages.vendor-dashboard';


    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(UserRoles::Manager);
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    protected function getViewData(): array
    {
        $userId = $this->user->id;
        return [
            'user'          => $this->user,
            'productCount'  => Product::where('user_id', $userId)->count(),
            'orderCount'    => Order::where('customer_id', $userId)->count(),
            'brandCount'    => ProductBrand::where('user_id', $userId)->count(),
        ];
    }
}
