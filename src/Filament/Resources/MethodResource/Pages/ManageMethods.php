<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\MethodResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\MethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMethods extends ManageRecords
{
    protected static string $resource = MethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
