<?php

namespace Xbigdaddyx\Falcon\Filament\Pages;

use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Form;
use Filament\Forms;
use Xbigdaddyx\Falcon\Models\Category;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;

class AssetDashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersAction;
    protected static string $routePath = 'asset';
    protected static ?string $title = 'Assets Dashboard';
    protected static ?string $navigationIcon = 'tabler-devices-dollar';
    public function getColumns(): int|string|array
    {
        return 12;
    }
    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->form([
                    \Filament\Forms\Components\Select::make('category_id')
                        ->default('9d215763-ac80-4675-b044-09587518b629')
                        ->label('Type')
                        ->options(function () {
                            $buyers = Category::all();
                            return $buyers->pluck('finance_asset_type', 'uuid');
                        }),
                    // ...
                ]),
        ];
    }
    // public function filtersForm(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\Section::make()
    //                 ->schema([
    //                     \Filament\Forms\Components\Select::make('category_id')
    //                         ->default('9d215763-ac80-4675-b044-09587518b629')
    //                         ->label('Type')
    //                         ->options(function () {
    //                             $buyers = Category::all();
    //                             return $buyers->pluck('finance_asset_type', 'uuid');
    //                         }),
    //                 ])
    //                 ->columns(3),
    //         ]);
    // }


    public function getWidgets(): array
    {
        return [

            \Xbigdaddyx\Falcon\Filament\Widgets\AssetOverallStat::class,
            \Xbigdaddyx\Falcon\Filament\Widgets\AssetCostChart::class,
            \Xbigdaddyx\Falcon\Filament\Widgets\AssetCategoryChart::class,
            \Xbigdaddyx\Falcon\Filament\Widgets\AssetPurchasedChart::class,
            // \Xbigdaddyx\Beverly\Filament\Widgets\CartonBoxPoChart::class,
        ];
    }
}
