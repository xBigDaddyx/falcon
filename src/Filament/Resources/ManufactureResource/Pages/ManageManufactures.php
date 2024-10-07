<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\ManufactureResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\ManufactureResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageManufactures extends ManageRecords
{
    protected static string $resource = ManufactureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
