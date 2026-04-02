<?php

namespace App\Providers\Filament;

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

class PortalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('portal')
            ->path('portal')
            ->path('portal')
            ->login()
            ->registration(\App\Filament\Pages\Auth\RegisterHuissier::class)
            ->colors([
                'primary' => Color::Sky,
            ])
            ->font('Cairo')
            ->brandName('بوابة المفوض')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\StatsOverview::class,
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
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => '<style>
                    /* Force Global Scrollbar to the Right */
                    html {
                        direction: ltr !important;
                    }
                    body {
                        direction: rtl !important;
                        text-align: right;
                    }
                    
                    /* Fix Filament Sidebar and Main Layout */
                    .fi-layout, .fi-sidebar, .fi-topbar, .fi-main {
                        direction: rtl !important;
                    }

                    /* Specific fix for internal scrollables (like tables) if needed */
                    .fi-ta-content, .fi-modal-content {
                        /* Often these need the same LTR wrapper + RTL inner trick, 
                           but let us start with global window scroll first */
                    }

                    /* Make scrollbars thinner and less intrusive */
                    ::-webkit-scrollbar {
                        width: 8px;
                        height: 8px;
                    }
                    ::-webkit-scrollbar-track {
                        background: transparent; 
                    }
                    ::-webkit-scrollbar-thumb {
                        background-color: rgba(156, 163, 175, 0.5); 
                        border-radius: 4px;
                    }
                    ::-webkit-scrollbar-thumb:hover {
                        background-color: rgba(107, 114, 128, 0.8); 
                    }
                    /* Firefox */
                    * {
                        scrollbar-width: thin;
                        scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
                    }
                </style>'
            );
    }
}
