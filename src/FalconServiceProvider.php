<?php

namespace Xbigdaddyx\Falcon;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schedule;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Xbigdaddyx\Falcon\Column\SpecificationColumn;
use Xbigdaddyx\Falcon\Commands\FalconCommand;
use Xbigdaddyx\Falcon\Events\MethodAssigned;
use Xbigdaddyx\Falcon\Filament\Components\QrViewEntry;
use Xbigdaddyx\Falcon\Filament\Components\SpecificationEntry;
use Xbigdaddyx\Falcon\Filament\Pages\AssetDashboard;
use Xbigdaddyx\Falcon\Filament\Pages\InventoryDashboard;
use Xbigdaddyx\Falcon\Filament\Resources\BrandResource\Widgets\MostUsedBrand;
use Xbigdaddyx\Falcon\Listeners\CalculateDepreciation;
use Xbigdaddyx\Falcon\Livewire\Pages\Inventory\ViewInventory;
use Xbigdaddyx\Falcon\Models\Asset as ModelsAsset;
use Xbigdaddyx\Falcon\Testing\TestsFalcon;

class FalconServiceProvider extends PackageServiceProvider
{
    public static string $name = 'falcon';

    public static string $viewNamespace = 'falcon';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('xbigdaddyx/falcon');
            });

        $configFileName = $package->shortName();
        if (file_exists($package->basePath("/../routes/web.php"))) {
            $package->hasRoutes("web");
        }
        if (file_exists($package->basePath("/../routes/api.php"))) {
            $package->hasRoutes("api");
        }
        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        \Illuminate\Support\Facades\Blade::componentNamespace('Xbigdaddyx\\Falcon\\Components', 'falcon');
        $this->publishes([__DIR__ . '/../public/vendor/xbigdaddyx/falcon' => public_path('vendor/xbigdaddyx/falcon')], 'falcon-assets');
        Event::listen(MethodAssigned::class, CalculateDepreciation::class);
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $assets = ModelsAsset::has('methods')->get();
            foreach ($assets as $asset) {
                $schedule->command('falcon:period-check ' . $asset->uuid)->dailyAt('01:00');
            }
        });
        Livewire::component('specification-entry', SpecificationEntry::class);
        Livewire::component('view-inventory', ViewInventory::class);
        Livewire::component('qr-view-entry', QrViewEntry::class);
        Livewire::component('inventory-dashboard', InventoryDashboard::class);
        Livewire::component('asset-dashboard', AssetDashboard::class);
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/falcon/{$file->getFilename()}"),
                ], 'falcon-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFalcon());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'xbigdaddyx/falcon';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('falcon', __DIR__ . '/../resources/dist/components/falcon.js'),
            // Css::make('falcon-styles', __DIR__ . '/../resources/dist/falcon.css'),
            // Js::make('falcon-scripts', __DIR__ . '/../resources/dist/falcon.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FalconCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_falcon_table',
        ];
    }
}
