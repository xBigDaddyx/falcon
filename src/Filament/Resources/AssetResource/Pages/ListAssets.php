<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\AssetResource\Pages;

use App\Imports\AssetImport;
use Xbigdaddyx\Falcon\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary")
                ->slideOver()
                ->color("primary")
                ->use(AssetImport::class),
            Actions\CreateAction::make(),
        ];
    }
}
