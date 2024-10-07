<?php

namespace Xbigdaddyx\Falcon;

use Filament\Contracts\Plugin;
use Filament\Panel;


class FalconPlugin implements Plugin
{
    public function getId(): string
    {
        return 'falcon';
    }

    public function register(Panel $panel): void
    {
        $panel

            ->pages([
                //
            ])
            ->resources([
                \Xbigdaddyx\Falcon\Filament\Resources\AgeResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\StatusResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\ConditionResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\SubCategoryResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\CategoryResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\AssetResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\LocationResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\InventoryResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\MethodResource::class,
                \Xbigdaddyx\Falcon\Filament\Resources\ManufactureResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
