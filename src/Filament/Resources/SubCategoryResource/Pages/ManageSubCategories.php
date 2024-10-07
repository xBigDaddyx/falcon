<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\SubCategoryResource\Pages;

use Xbigdaddyx\Falcon\Filament\Resources\SubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubCategories extends ManageRecords
{
    protected static string $resource = SubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
