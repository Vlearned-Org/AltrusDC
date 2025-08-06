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
use Filament\Navigation\NavigationGroup;
//use App\Filament\Pages\Settings;
use Filament\Navigation\MenuItem;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
        ->sidebarWidth('18rem')
            ->default()
                    ->breadcrumbs(false)
 ->databaseNotifications()
  ->databaseNotificationsPolling('30s')
            ->collapsibleNavigationGroups(false)
           // ->topNavigation()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
             
            ->navigationGroups([
                  NavigationGroup::make()
        ->label('Organization')
       ->icon('heroicon-s-building-office')  ,
    NavigationGroup::make()
        ->label('ESG Data')
        ->icon('heroicon-o-shield-check'), 
    NavigationGroup::make()
        ->label('Travel Records')
        ->icon('heroicon-o-globe-alt'), 
        
    NavigationGroup::make()
        ->label('Training Management')
        ->icon('heroicon-o-academic-cap'), 
    NavigationGroup::make()
        ->label('User Management')
        ->icon('heroicon-o-users'), 
        
  
])
  ->userMenuItems([
            MenuItem::make()
                ->label('Settings')
                //->url(fn (): string => Settings::getUrl())
                ->icon('heroicon-o-cog-6-tooth'),
           'profile' => MenuItem::make()->label('Edit profile'),
            'logout' => MenuItem::make()->label('Log out'),
        ])
 ->plugin(
            \Hasnayeen\Themes\ThemesPlugin::make()
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
              
            
           // \Hasnayeen\Themes\Http\Middleware\SetTheme::class
      
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
