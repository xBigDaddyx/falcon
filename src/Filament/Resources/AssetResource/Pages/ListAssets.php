<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\AssetResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
