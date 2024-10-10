<?php

namespace Xbigdaddyx\Falcon\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Xbigdaddyx\Falcon\Models\Asset;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AssetOverallStat extends BaseWidget
{
    use InteractsWithPageFilters;
    protected int | string | array $columnSpan = 12;
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        $type = $this->filters['category_id'] ?? null;
        $assets =  Asset::whereHas('inventories', function ($q) {
            $q->where('status_id', '9d21b8f9-d66e-4143-9240-0dc9f4d554f4');
        })->count();
        return [
            Stat::make('In Use', $assets)
                ->description('Assets')
                ->descriptionIcon('tabler-user-check')
                // ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('In Use', $assets)
                ->description('Assets')
                ->descriptionIcon('tabler-user-check')
                // ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('In Use', $assets)
                ->description('Assets')
                ->descriptionIcon('tabler-user-check')
                // ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
