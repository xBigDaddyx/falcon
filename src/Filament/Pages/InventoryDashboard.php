<?php

namespace Xbigdaddyx\Falcon\Filament\Pages;


class InventoryDashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = 'inventory';
    protected static ?string $title = 'Inventories Dashboard';
    protected static ?string $navigationIcon = 'tabler-devices-bolt';
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
