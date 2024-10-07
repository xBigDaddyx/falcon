<?php

namespace Xbigdaddyx\Falcon\Filament\Resources;

use Xbigdaddyx\Falcon\Filament\Resources\ManufactureResource\Pages;
use Xbigdaddyx\Falcon\Filament\Resources\ManufactureResource\RelationManagers;
use Xbigdaddyx\Falcon\Models\Manufacture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use stdClass;

class ManufactureResource extends Resource
{
    protected static ?string $model = Manufacture::class;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'tabler-devices-cog';
    // public static function getGlobalSearchEloquentQuery(): Builder
    // {
    //     // return parent::getGlobalSearchEloquentQuery()->with(['inventories']);
    // }
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'website'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {

        return [
            'Description' => $record->description,

        ];
    }
    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            // Action::make('edit')
            //     ->url(static::getUrl('edit', ['record' => $record]), shouldOpenInNewTab: true),
            // Action::make('view')
            //     ->url(static::getUrl('view', ['record' => $record])),
        ];
    }
    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->name;
    }
    public static function getNavigationLabel(): string
    {
        return trans('falcon::falcon.resource.manufacture.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('falcon::falcon.resource.manufacture.label');
    }

    public static function getLabel(): string
    {
        return trans('falcon::falcon.resource.manufacture.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('falcon::falcon.resource.manufacture.group');
    }

    public function getTitle(): string
    {
        return trans('falcon::falcon.resource.manufacture.title.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pictures')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->directory('logo-manufactures')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend('manufactures-'),
                            )
                            ->downloadable()
                            ->image()
                            ->imageEditor(),
                    ]),
                Forms\Components\Section::make('General')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->url(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->state(
                        static function (Tables\Contracts\HasTable $livewire, stdClass $rowLoop): string {
                            return (string) (
                                $rowLoop->iteration +
                                ($livewire->getTableRecordsPerPage() * (
                                    $livewire->getTablePage() - 1
                                ))
                            );
                        }
                    ),
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->copyable()
                    ->copyableState(fn(string $state): string => "URL: {$state}"),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageManufactures::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
