<?php

namespace App\Providers\Filament;

use App\NavigationGroup;
use App\NavigationGroupEnum;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup as NavigationNavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->collapsibleNavigationGroups()
            // ->brandLogo(asset('logo-unmaris.png'))
            // ->brandLogoHeight('2rem')
            // ->brandLogo(fn () => view('filament.brand'))
            ->favicon(asset('logo-unmaris.png'))
            ->brandLogoHeight('2rem')
            ->brandName("SPMI UNMARIS")
            ->colors([
                'primary' => Color::Blue,
            ])
            ->navigationGroups([
                NavigationNavigationGroup::make()
                    ->label(NavigationGroupEnum::MASTER->value)
                    ->icon('heroicon-o-squares-2x2')
                    ->collapsed(),
                NavigationNavigationGroup::make()
                    ->label(NavigationGroupEnum::EDOM->value)
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->collapsed(),
                NavigationNavigationGroup::make()
                    ->label(NavigationGroupEnum::AMI->value)
                    ->icon('heroicon-o-shield-check')
                    ->collapsed(),
                NavigationNavigationGroup::make()
                    ->label(NavigationGroupEnum::PORTAL->value)
                    ->icon('heroicon-o-globe-alt')
                    ->collapsed(),
                NavigationNavigationGroup::make()
                    ->label(NavigationGroupEnum::SETTINGS->value)
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
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
            ]);
    }
}
