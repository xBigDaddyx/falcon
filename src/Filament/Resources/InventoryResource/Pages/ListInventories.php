<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\InventoryResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\InventoryResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Xbigdaddyx\Falcon\Models\Status;
use Illuminate\Support\Arr;
use Xbigdaddyx\Falcon\Models\Inventory;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;
    public function getTabs(): array
    {
        if (config('falcon.has_tenant')) {
            return [
                'all' => Tab::make(),
                'in-use' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('company_id', auth()->user()->company_id)->where('status_id', '9d21b8f9-d66e-4143-9240-0dc9f4d554f4'))
                    ->icon('tabler-checklist')
                    ->badge(Inventory::query()->where('company_id', auth()->user()->company_id)->where('status_id', '9d21b8f9-d66e-4143-9240-0dc9f4d554f4')->count())
                    ->badgeColor('warning'),
                'available' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('company_id', auth()->user()->company_id)->where('status_id', '9d21b92f-97c7-49b8-96de-41e4b5f56a51'))
                    ->icon('tabler-checkup-list')
                    ->badge(Inventory::query()->where('company_id', auth()->user()->company_id)->where('status_id', '9d21b92f-97c7-49b8-96de-41e4b5f56a51')->count())
                    ->badgeColor('success'),
                'requires-repair' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('company_id', auth()->user()->company_id)->where('status_id', '9d21b993-b8d1-4888-891e-41b14d68fe69'))
                    ->icon('tabler-settings-down')
                    ->badge(Inventory::query()->where('company_id', auth()->user()->company_id)->where('status_id', '9d21b993-b8d1-4888-891e-41b14d68fe69')->count())
                    ->badgeColor('danger'),
            ];
        }
        return [
            'all' => Tab::make(),
            'in-use' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '9d21b8f9-d66e-4143-9240-0dc9f4d554f4'))
                ->icon('tabler-checklist')
                ->badge(Inventory::query()->where('status_id', '9d21b8f9-d66e-4143-9240-0dc9f4d554f4')->count())
                ->badgeColor('warning'),
            'available' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '9d21b92f-97c7-49b8-96de-41e4b5f56a51'))
                ->icon('tabler-checkup-list')
                ->badge(Inventory::query()->where('status_id', '9d21b92f-97c7-49b8-96de-41e4b5f56a51')->count())
                ->badgeColor('success'),
            'requires-repair' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '9d21b993-b8d1-4888-891e-41b14d68fe69'))
                ->icon('tabler-settings-down')
                ->badge(Inventory::query()->where('status_id', '9d21b993-b8d1-4888-891e-41b14d68fe69')->count())
                ->badgeColor('danger'),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
