<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\AgeResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\AgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAges extends ManageRecords
{
    protected static string $resource = AgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
