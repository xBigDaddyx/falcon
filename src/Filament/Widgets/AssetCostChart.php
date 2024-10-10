<?php

namespace Xbigdaddyx\Falcon\Filament\Widgets;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Support\RawJs;
use Flowframe\Trend\Trend;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Xbigdaddyx\Falcon\Models\Asset;
use Xbigdaddyx\Falcon\Models\Category;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AssetCostChart extends ApexChartWidget
{
    use InteractsWithPageFilters;
    protected int | string | array $columnSpan = 8;
    protected static ?int $sort = 1;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'assetCostChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Purchased Asset Cost';
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
            ->sum('purchased_price');

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total',
                    'data' => $assets->pluck('aggregate'),
                ],
            ],
            'xaxis' => [
                'categories' => $assets->pluck('date'),

                'axisBorder' => [
                    'show' => false
                ],
                'axisTicks' => [
                    'show' => false
                ],
                'crosshairs' => [
                    'fill' => [
                        'type' => 'gradient',
                        'gradient' => [
                            'colorFrom' => '#D8E3F0',
                            'colorTo' => '#BED1E6',
                            'stops' => [0, 100],
                            'opacityFrom' => 0.4,
                            'opacityTo' => 0.5,
                        ]
                    ]
                ],
                // 'labels' => [
                //     'style' => [
                //         'fontFamily' => 'inherit',
                //         'fontWeight' => 600,
                //     ],
                // ],
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 10,
                    'dataLabels' => [
                        'position' => 'top', // top, center, bottom
                    ],
                ]
            ],

            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#6BC1AE'],

        ];
    }
    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
    {
        // xaxis: {
        //     labels: {
        //         formatter: function (val, timestamp, opts) {
        //             return val + '/24'
        //         }
        //     }
        // },
        yaxis: {
            labels: {
                formatter: function (val, index) {
                    return 'IDR ' + (new Intl.NumberFormat().format(val));
                }
            }
        },

        dataLabels: {
            enabled: true,
            formatter: function (val, opt) {
                return 'IDR ' + (new Intl.NumberFormat().format(val))
            },
            offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          },

        }
    }
    JS);
    }
}
