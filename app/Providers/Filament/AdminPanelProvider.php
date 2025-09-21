<?php

namespace App\Providers\Filament;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\UserMenuItem;
use Filament\Facades\Filament;
use App\Models\{Order, Tenant, User, Ticket};
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function boot()
    {
        FilamentAsset::register([
            Css::make('admin-custom', asset('css/admin-custom.css')),
        ]);
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration(Register::class)
            ->passwordReset()
            ->emailVerification()
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                \App\Filament\Pages\AdminDashboard::class,
                \App\Filament\Pages\VendorDashboard::class,
            ])
            ->userMenuItems([
                UserMenuItem::make()
                    ->label(function () {
                        $user = Auth::user();

                        if ($user->hasRole(UserRoles::Admin)) {
                            $newVendors = User::where('role', 2)->whereNull('email_verified_at')->count();
                            return 'Vendors' . ($newVendors > 0 ? " ($newVendors)" : '');
                        }

                        return 'Vendors';
                    })
                    ->icon('heroicon-o-users')
                    ->url('/users')
                    ->visible(fn() => Auth::user()->hasRole(UserRoles::Admin)),

                UserMenuItem::make()
                    ->label(function () {
                        $user = Auth::user();

                        $vendorOrderCount = Order::whereHas('customer', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })->count();

                        return 'Orders' . ($vendorOrderCount > 0 ? " ($vendorOrderCount)" : '');
                    })
                    ->icon('heroicon-o-shopping-bag')
                    ->url('/orders')
                    ->visible(function () {
                        $user = Auth::user();
                        return !$user->hasRole(UserRoles::Admin); // Only show for non-admins
                    }),

               

                UserMenuItem::make()
                    ->label(function () {
                        $user = Auth::user();

                        if ($user->hasRole(UserRoles::Admin)) {
                            $openTickets = Ticket::where('status', 'open')->count();
                            return 'Tickets' . ($openTickets > 0 ? " ($openTickets)" : '');
                        }

                        $openTickets = Ticket::where('user_id', $user->id)->where('status', 'open')->count();
                        return 'Tickets' . ($openTickets > 0 ? " ($openTickets)" : '');
                    })
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url('/tickets'),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
