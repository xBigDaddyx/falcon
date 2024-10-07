<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\StatusResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\StatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStatuses extends ManageRecords
{
    protected static string $resource = StatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
