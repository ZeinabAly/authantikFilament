<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\Client\StatsClient;
use App\Http\Middleware\EnsureUseHasRoleUser;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class ClientPanelProvider extends PanelProvider
{
    // public function boot()
    // {
    //     Filament::serving(function () {
    //         if (auth()->check() && !auth()->user()->is_active) {
    //             auth()->logout();
    //             redirect()->route('filament.clien.auth.login');
    //             return Notification::make()
    //                 ->title('Votre compte a été desactivé ! ')
    //                 ->success()
    //                 ->send();
    //         }

    //         if (auth()->check() && auth()->user()->hasRole('Admin')) {
    //             redirect()->route('filament.client.auth.login');
    //             auth()->logout();
    //             return Notification::make()
    //                 ->title('Votre compte a été desactivé ! ')
    //                 ->success()
    //                 ->send();
    //         }
    //     });
    // } 

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('client')
            ->path('client')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources/Client'), for: 'App\\Filament\\Resources\\Client')
            ->discoverPages(in: app_path('Filament/Pages/Client'), for: 'App\\Filament\\Pages\\Client')
            ->pages([
                // Pages\Client\Dashboard::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                // StatsClient::class,
            ])
            // Inserer l'icone de notification
            ->renderHook(
                'panels::user-menu.before',
                fn (): string => view('filament.custom.notification-icon')->render()
            )
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
                // EnsureUseHasRoleUser::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->brandName('AUTHANTIK')
            ->favicon(asset('favicon.png'));
    }
}
