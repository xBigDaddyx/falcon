<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\ConditionResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\ConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConditions extends ManageRecords
{
    protected static string $resource = ConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
