<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Support\Assets\Css;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\UserMenuItem;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{

    public function boot()
    {
        Filament::serving(function () {
            if(auth()->check()){
                // Ajouter un item au menu utilisateur
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                        ->label('Mon profil')  // Libellé du lien
                        ->url(route('filament.admin.resources.admin.employees.profile', ['record' => auth()->user()->id]))  // URL du lien
                        ->icon('heroicon-o-user')  // Icône (optionnel)
                    ]);
                }
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources/Admin'), for: 'App\\Filament\\Resources\\Admin')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            // ->pages([
            //     Pages\Dashboard::class,
            // ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->brandName('AUTHANTIK')
            // ->brandLogo(asset('logoAuth.png'))
            // ->brandLogoHeight('4rem')
            ->favicon(asset('favicon.png'))
            

            // Les assets
            ->assets([
                Css::make('custom-stylesheet', resource_path('css/filament/pages/profile.css')),
                // Css::make('custom-stylesheet', resource_path('css/filament/pages/modal-styles.css')),
            ])
            // INSERER LE BOUTON PASSER UNE COMMANDE A DROITE DANS LA TOPBAR 
            ->renderHook(
                'panels::user-menu.before',
                fn (): string => view('filament.custom.topbar-button')->render()
            )
            // INSERER LA MODAL DANS LE MAIN DU BODY
            ->renderHook(
                'panels::content.start',
                fn (): string => view('filament.resources.admin.order-resource.pages.create-order-modal')->render()
            );;
            
    }
}
