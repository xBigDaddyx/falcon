<?php

namespace Xbigdaddyx\Falcon;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\MaxWidth;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Xbigdaddyx\Falcon\Filament\Resources\BrandResource\Widgets\MostUsedBrand;

class FalconPanelServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        if (config('falcon.has_tenant')) {
            $panel->tenantMenuItems([
                'register' => MenuItem::make()->label('Register new company')
                    ->visible(fn(): bool => auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('Information Technology')),
                'profile' => MenuItem::make()->label('Company profile'),
            ])

                ->tenantMiddleware([
                    //
                ], isPersistent: true)
                //->tenantRoutePrefix('company')
                ->tenant(\Xbigdaddyx\Fuse\Domain\Company\Models\Company::class, 'short_name', 'company')
                // ->tenantRegistration(RegisterCompany::class)
                ->tenantProfile(\Xbigdaddyx\Fuse\Domain\System\Filament\Pages\EditCompanyProfile::class);
        }
        return $panel
            ->default()
            ->id('falcon')
            ->path('falcon')
            ->emailVerification()
            // ->profile(Domain\User\Filament\Pages\Auth\Profile::class)
            ->unsavedChangesAlerts()
            ->passwordReset()
            // ->viteTheme('resources/css/filament/falcon/theme.css')
            // ->topNavigation()
            // ->spa()
            ->maxContentWidth(MaxWidth::Full)
            ->login()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->font('Poppins')
            ->sidebarCollapsibleOnDesktop()
            ->brandLogo(asset('storage/images/logo/teresa_falcon_logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('storage/images/logo/teresa_falcon_logo.png'))

            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                    //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
                    ->visible(function (): bool {
                        return auth()->user()->company()->exists();
                    }),
            ])
            ->colors([
                'secondary' => '#82ee99',
                'primary' => '#0C6478'

            ])
            ->plugins([
                \CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin::make()
                    ->highlighter(false),
                \ChrisReedIO\Socialment\SocialmentPlugin::make()
                    ->registerProvider('azure', 'microsoft', 'Sign in with Microsoft'),
                \Xbigdaddyx\Falcon\FalconPlugin::make(),
                \Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin::make(),
                \Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->setNavigationLabel('My Profile')
                    ->setNavigationGroup('Group Profile')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->canAccess(fn() => auth()->user()->id === 1)
                    ->shouldRegisterNavigation(false)
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm()
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                        rules: 'mimes:jpeg,png|max:1024' //only accept jpeg and png files with a maximum size of 1MB
                    ),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'Xbigdaddyx\\Falcon\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'Xbigdaddyx\\Falcon\\Filament\\Pages')
            ->pages([
                \Xbigdaddyx\Falcon\Filament\Pages\AssetDashboard::class,
                \Xbigdaddyx\Falcon\Filament\Pages\InventoryDashboard::class,
                // Dashboard::class,
                // \Xbigdaddyx\Falcon\Filament\Pages\CartonDashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'Xbigdaddyx\\Falcon\\Filament\\Widgets')

            ->widgets([
                AccountWidget::class,

                // Widgets\AccountWidget::class,
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
