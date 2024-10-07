<?php

namespace Xbigdaddyx\Falcon\Filament\Pages;


class AssetDashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = 'asset';
    protected static ?string $title = 'Assets Dashboard';
    protected static ?string $navigationIcon = 'tabler-devices-dollar';
    public function getColumns(): int|string|array
    {
        return 12;
    }



    public function getWidgets(): array
    {
        return [
            // \Xbigdaddyx\Beverly\Filament\Widgets\CartonBoxSummaryChart::class,
            // \Xbigdaddyx\Beverly\Filament\Widgets\CartonBoxPercentageTypeChart::class,
            // \Xbigdaddyx\Beverly\Filament\Widgets\CartonBoxPoChart::class,
        ];
    }
}
