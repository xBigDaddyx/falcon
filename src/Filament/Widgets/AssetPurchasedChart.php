<?php

namespace Xbigdaddyx\Falcon\Filament\Widgets;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Flowframe\Trend\Trend;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Xbigdaddyx\Falcon\Models\Asset;
use Xbigdaddyx\Falcon\Models\Category;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AssetPurchasedChart extends ApexChartWidget
{
    use InteractsWithPageFilters;
    protected int | string | array $columnSpan = 8;
    protected static ?int $sort = 3;
    protected static ?string $footer = 'Purchased asset each month in year, can be filtered by type.';

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'assetPurchasedChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Purchased Asset Quantity';
    // protected function getFormSchema(): array
    // {
    //     return [
    //         \Filament\Forms\Components\Select::make('category_id')
    //             ->default('9d215763-ac80-4675-b044-09587518b629')
    //             ->label('Type')
    //             ->options(function () {
    //                 $buyers = Category::all();
    //                 return $buyers->pluck('finance_asset_type', 'uuid');
    //             }),

    //     ];
    // }
    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $type = $this->filters['category_id'];
        $assets =  Trend::query(
            Asset::query()->where('company_id', Filament::getTenant()->id ?? auth()->user()->company_id)->where('category_id', $type)
        )
            ->dateColumn('purchased_at')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Assets',
                    'data' => $assets->pluck('aggregate'),
                ],
            ],
            'xaxis' => [
                'categories' => $assets->pluck('date'),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#70DE99'],
        ];
    }
}
