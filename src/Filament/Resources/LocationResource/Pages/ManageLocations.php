<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\LocationResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLocations extends ManageRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
