<?php

namespace Xbigdaddyx\Falcon\Filament\Widgets;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Xbigdaddyx\Falcon\Models\Asset;

class AssetCategoryChart extends ApexChartWidget
{
    protected int | string | array $columnSpan = 4;
    protected static ?int $sort = 4;
    protected static ?string $footer = 'Summary of all assets ordered by type.';
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'assetCategoryChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Asset by Type Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $assets = DB::table('falcon_assets')
            ->join('falcon_categories', 'falcon_categories.uuid', 'falcon_assets.category_id')
            ->select(DB::raw('count(falcon_assets.uuid) as count, falcon_categories.finance_asset_type'))
            ->where('falcon_assets.company_id', Filament::getTenant()->id)
            ->groupBy('finance_asset_type')
            ->get();
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => $assets->pluck('count'),
            'labels' => $assets->pluck('finance_asset_type'),
            'legend' => [
                'labels' => [
                    'colors' => '#0FA4A6',
                    'fontWeight' => 600,
                ],
            ],
            'colors' => ['#0FA4A6'],
        ];
    }
}
