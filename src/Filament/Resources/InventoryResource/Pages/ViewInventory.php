<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\InventoryResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\InventoryResource;
use Filament\Actions;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components;
use Xbigdaddyx\Falcon\Models\Asset;
use Xbigdaddyx\Falcon\Models\Category;
use Xbigdaddyx\Falcon\Models\Inventory;
use Xbigdaddyx\Falcon\Models\Location;
use Xbigdaddyx\Falcon\Models\SubCategory;

class ViewInventory extends ViewRecord
{

    protected static string $resource = InventoryResource::class;
    protected static string $view = 'falcon::filament.resources.inventories.pages.view-inventory';
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('tabler-pencil'),
            Actions\Action::make('Acquisition')
                ->hidden(fn(Model $record): bool => $record->has('asset')->exists())
                ->icon('tabler-arrow-autofit-down')
                ->color('warning')
                ->modalHeading('Asset Acquisition')
                ->form([
                    Components\Section::make('General Information')
                        ->description('Detail of general information for the asset.')
                        ->schema([
                            Components\TextInput::make('asset_code')
                                ->label('Asset Code')
                                ->required(),
                            Components\Select::make('category_id')
                                ->options(Category::query()->pluck('name', 'uuid'))
                                ->label('Category'),
                            Components\Select::make('sub_category_id')
                                ->options(SubCategory::query()->pluck('name', 'uuid'))
                                ->label('Sub Category'),
                            Components\TextInput::make('purchased_price')
                                ->numeric()
                                ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 8)
                                ->label('Purchased Price')
                                ->required(),
                            Components\DatePicker::make('purchased_at')
                                ->label('Purchased At')
                                ->required(),
                            Components\TextInput::make('purchase_order')
                                ->label('Purchase Order'),
                            Components\Select::make('location_id')
                                ->options(Location::query()->pluck('name', 'uuid'))
                                ->label('Location'),
                        ])->columns(2),

                ])
                ->action(function (array $data, Inventory $record): void {
                    $asset =  Asset::create(
                        [
                            'asset_code' => $data['asset_code'],
                            'purchased_price' => $data['purchased_price'],
                            'purchased_at' => $data['purchased_at'],
                            'purchase_order' => $data['purchase_order'],
                            'location_id' => $data['location_id'],
                            'category_id' =>  $data['category_id'],
                            'sub_category_id' => $data['sub_category_id'],
                        ]
                    );

                    $record->asset()->associate($asset);
                    $record->save();
                }),
        ];
    }
}
