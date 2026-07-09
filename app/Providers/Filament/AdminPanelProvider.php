<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\DashboardPage;
use App\Filament\Pages\EnvEditor\EnvEditorPage;
use App\Filament\Pages\GeneralSettings\GeneralSettingsPage;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    protected $data;
    protected array $plugins;

    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('curator', __DIR__.'/../../../public/css/awcodes/curator/curator.css'),
        ], 'awcodes/curator');
    }

    public function panel(Panel $panel): Panel
    {
        $this->data = config('general-settings') ?: [];

        $this->plugins = [
            \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                ->gridColumns([
                    'default' => 1,
                    'sm' => 2,
                    'lg' => 3
                ])
                ->sectionColumnSpan(1)
                ->checkboxListColumns([
                    'default' => 1,
                    'sm' => 2,
                    'lg' => 4,
                ])
                ->resourceCheckboxListColumns([
                    'default' => 1,
                    'sm' => 2,
                ]),
            \GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin::make()
                ->navigationGroup('Settings')
                ->navigationLabel('Environment')
                ->navigationIcon('heroicon-o-command-line')
                ->navigationSort(2)
                ->viewPage(EnvEditorPage::class)
                ->hideKeys(
                    'APP_MAINTENANCE_DRIVER',
                    '# APP_MAINTENANCE_STORE',
                    'PHP_CLI_SERVER_WORKERS',
                    'BCRYPT_ROUNDS'
                ),
            \Awcodes\Curator\CuratorPlugin::make()
                ->label('Media')
                ->navigationIcon('heroicon-o-photo')
                ->navigationGroup('Article')
                ->navigationSort(2)
                ->navigationCountBadge(false)
                ->registerNavigation(true)
                ->defaultListView('grid')
                ->resource(\App\Filament\Resources\MediaResource::class),
        ];

        return $panel
            ->default()
            ->favicon(function () {
                $tmp = $this->data['site_favicon'] ?? null;
                return $tmp ? Storage::url($tmp) : null;
            })
            ->brandName($this->data['site_name'] ?? config('app.name'))
            ->brandLogo(function () {
                $tmp = $this->data['site_logo'] ?? null;
                return $tmp ? Storage::url($tmp) : null;
            })
            ->id('dashboard')
            ->path($this->data['site_dashboard_url'] ?? 'admin')
            ->login(Login::class)
            ->passwordReset()
            ->emailVerification()
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                MenuItem::make()
                    ->label('Dashboard')
                    ->url('/'.($this->data['site_dashboard_url'] ?? 'admin'))
                    ->icon('heroicon-o-home'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                DashboardPage::class,
                GeneralSettingsPage::class,
            ])
            ->widgets([
                //
            ])
            ->navigationItems([
                NavigationItem::make('Go to web')
                    ->url(function () : string {
                        $tmp = $this->data['navigation'] ?? '';
                        return '/'.$tmp['home']['slug'];
                    }, shouldOpenInNewTab: true)
                    ->icon('heroicon-o-globe-alt')
                    ->visible(function () : bool {
                        $tmp = $this->data['navigation'] ?? null;
                        return isset($tmp['home']['slug']);
                    })
                    ->sort(-1),
            ])
            ->navigationGroups([
                'Settings',
                'Profil Daerah',
                'Filament Shield',
                'Accounts',
                'Article',
                'Sponsors',
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
            ->plugins($this->plugins);
    }
}
