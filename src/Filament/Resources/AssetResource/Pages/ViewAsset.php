<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\AssetResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
