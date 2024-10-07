<?php

namespace Xbigdaddyx\Falcon\Filament\Resources;

use Xbigdaddyx\Falcon\Filament\Resources\InventoryResource\Pages;
use Xbigdaddyx\Falcon\Filament\Resources\InventoryResource\RelationManagers;
use Xbigdaddyx\Falcon\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Rupadana\FilamentSwiper\Infolists\Components\SwiperImageEntry;
use stdClass;
use Xbigdaddyx\Falcon\Filament\Components\QrViewEntry;
use Illuminate\Contracts\View\View;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $recordTitleAttribute = 'model';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'tabler-device-airpods-case';
    // public static function getGlobalSearchEloquentQuery(): Builder
    // {
    //     return parent::getGlobalSearchEloquentQuery()->with(['company']);
    // }
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'model'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {

        return [
            // 'Category' => $record->category->name,
            // 'Sub Category' => $record->subCategory->name,

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
        return trans('falcon::falcon.resource.inventory.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('falcon::falcon.resource.inventory.label');
    }

    public static function getLabel(): string
    {
        return trans('falcon::falcon.resource.inventory.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('falcon::falcon.resource.inventory.group');
    }

    public function getTitle(): string
    {
        return trans('falcon::falcon.resource.inventory.title.resource');
    }

    public static function form(Form $form): Form
    {
        // return $form
        //     ->schema([
        //         Forms\Components\TextInput::make('pictures'),
        // Forms\Components\TextInput::make('manufacture')
        //     ->required()
        //     ->maxLength(255),
        // Forms\Components\TextInput::make('model')
        //     ->required()
        //     ->maxLength(255),
        // Forms\Components\TextInput::make('specifications')
        //     ->required(),
        // Forms\Components\TextInput::make('serial')
        //     ->required()
        //     ->maxLength(255),
        // Forms\Components\Select::make('condition_id')
        //     ->relationship('condition', 'name'),
        // Forms\Components\Select::make('status_id')
        //     ->relationship('status', 'name'),
        // Forms\Components\Select::make('asset_id')
        //     ->relationship('asset', 'asset_code'),
        //         // Forms\Components\TextInput::make('deleted_by')
        //         //     ->numeric(),
        //         // Forms\Components\TextInput::make('created_by')
        //         //     ->numeric(),
        //         // Forms\Components\TextInput::make('updated_by')
        //         //     ->numeric(),
        //     ]);

        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Gallery')
                        ->schema([
                            Forms\Components\FileUpload::make('pictures')
                                ->multiple()
                                ->label('Pictures')
                                ->directory('picture-devices')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('device-'),
                                )
                                ->downloadable()
                                ->image()
                                ->imageEditor(),
                        ]),

                ]),
                Forms\Components\Group::make([

                    // \Xbigdaddyx\Itsm\Filament\Forms\Components\QRCode::make('hostname')->label('QR Code')
                    //     ->hiddenOn('create'),

                    Forms\Components\Section::make('General')
                        ->schema([
                            Forms\Components\Select::make('manufacture_id')
                                ->relationship('manufacture', 'name')
                                ->inlineLabel()
                                ->required(),
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->inlineLabel(),
                            Forms\Components\TextInput::make('model')
                                ->required()
                                ->inlineLabel()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('serial')
                                ->required()
                                ->inlineLabel()
                                ->maxLength(255),
                            Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->inlineLabel(),
                            Forms\Components\Select::make('sub_category_id')
                                ->relationship('subCategory', 'name')
                                ->inlineLabel(),
                            Forms\Components\Select::make('condition_id')
                                ->relationship('condition', 'name')
                                ->inlineLabel(),
                            Forms\Components\Select::make('status_id')
                                ->relationship('status', 'name')
                                ->inlineLabel(),
                            // Forms\Components\Select::make('asset_id')
                            //     ->hiddenOn(['create'])
                            //     ->relationship('asset', 'asset_code')
                            //     ->inlineLabel(),

                        ])->columns(2),
                ]),
                Forms\Components\Repeater::make('specifications')
                    ->schema([
                        Forms\Components\TextInput::make('detail_item')
                            ->required()
                            ->inlineLabel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('detail_value')
                            ->required()
                            ->inlineLabel()
                            ->maxLength(255),
                    ])
                    ->deleteAction(
                        fn(Action $action) => $action->requiresConfirmation(),
                    )
                    ->itemLabel(fn(array $state): ?string => $state['detail_item'] ?? null)
                    ->grid(4)
                    ->collapsible()
                    ->reorderableWithButtons()
                    ->reorderableWithDragAndDrop(false)
                    ->columnSpanFull()

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
                Tables\Columns\ImageColumn::make('manufacture.logo')
                    ->label('Manufacture'),
                Tables\Columns\ImageColumn::make('pictures')
                    ->circular()
                    ->stacked(),
                Tables\Columns\TextColumn::make('name')
                    ->icon('tabler-id')
                    ->iconColor('warning')
                    ->description(fn(Model $record): string => $record->model)
                    ->weight(FontWeight::Bold)
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->hidden()
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->description(fn(Model $record): string => $record->category->description ?? '')
                    ->badge()
                    ->icon(fn(Model $record): string => $record->category->icon ?? 'tabler-file')
                    ->color(fn(Model $record): string => $record->category->color ?? 'primary'),
                Tables\Columns\TextColumn::make('subCategory.name')
                    ->description(fn(Model $record): string => $record->subCategory->description ?? '')
                    ->badge()
                    ->icon(fn(Model $record): string => $record->subCategory->icon ?? 'tabler-file')
                    ->color(fn(Model $record): string => $record->subCategory->color ?? 'primary'),
                Tables\Columns\TextColumn::make('condition.name')
                    ->tooltip(fn(Model $record): string => $record->condition->description)
                    ->badge()
                    ->icon(fn(Model $record): string => $record->condition->icon ?? 'tabler-file')
                    ->color(fn(Model $record): string => $record->condition->color ?? 'primary'),
                Tables\Columns\TextColumn::make('status.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(fn(Model $record): string => $record->status->description)
                    ->badge()
                    ->icon(fn(Model $record): string => $record->status->icon ?? 'tabler-file')
                    ->color(fn(Model $record): string => $record->status->color ?? 'primary'),
                Tables\Columns\TextColumn::make('asset.users.name')
                    ->icon('tabler-user')
                    ->label('Users')
                    ->listWithLineBreaks()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('editor.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_by')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Show Barcode')
                        ->icon('tabler-barcode')
                        ->color('warning')
                        ->modalIcon('tabler-barcode')
                        ->modalIconColor('warning')
                        ->modalHeading('Inventory Barcode')
                        ->modalDescription('This barcode for identify the inventory by scan.')
                        ->modalWidth(MaxWidth::ExtraSmall)
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->modalContent(fn(Inventory $record): View => view(
                            'falcon::filament.infolists.entries.qr-view-entry',
                            ['record' => $record],
                        )),
                    Tables\Actions\ViewAction::make()
                        ->color('primary'),
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                ])

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make([

                    Infolists\Components\ImageEntry::make('manufacture.logo')
                        ->grow(false)
                        ->hiddenLabel(),
                    Infolists\Components\Section::make('Gallery')
                        ->id('gallery')
                        ->icon('tabler-photo')
                        ->description('Pictures of this inventory.')
                        ->schema([
                            \Rupadana\FilamentSwiper\Infolists\Components\SwiperImageEntry::make('pictures')
                                ->navigation(true)
                                ->scrollbarHide(true)
                                ->autoplay()
                                ->autoplayDelay(5000)
                                ->size(400)
                                ->centeredSlides(),
                        ]),

                ])->columnSpanFull(),
                Infolists\Components\Group::make([

                    Infolists\Components\Section::make('General Information')
                        ->id('generalInformation')

                        ->icon('tabler-pencil-bolt')
                        ->description('Basic information of this inventory.')
                        ->schema([

                            Infolists\Components\TextEntry::make('name')
                                ->copyable()
                                ->inlineLabel()
                                ->icon('tabler-id')
                                ->iconColor('warning')
                                ->weight(FontWeight::Bold)
                                ->size(TextEntrySize::Large),
                            Infolists\Components\TextEntry::make('model')
                                ->weight(FontWeight::Bold)
                                ->inlineLabel(),
                            Infolists\Components\TextEntry::make('serial')
                                ->weight(FontWeight::Bold)
                                ->inlineLabel(),
                            Infolists\Components\TextEntry::make('manufacture.name')
                                ->weight(FontWeight::Bold)
                                ->inlineLabel(),
                            Infolists\Components\TextEntry::make('condition.name')
                                ->weight(FontWeight::Bold)
                                ->inlineLabel()
                                ->badge()
                                ->icon(fn(Model $record): string => $record->condition->icon ?? 'tabler-file')
                                ->color(fn(Model $record): string => $record->condition->color ?? 'primary'),
                            Infolists\Components\TextEntry::make('status.name')
                                ->weight(FontWeight::Bold)
                                ->inlineLabel()
                                ->badge()
                                ->icon(fn(Model $record): string => $record->status->icon ?? 'tabler-file')
                                ->color(fn(Model $record): string => $record->status->color ?? 'primary'),
                        ])->columns(2),
                    Infolists\Components\RepeatableEntry::make('specifications')
                        ->schema([
                            Infolists\Components\TextEntry::make('detail_item')
                                ->hiddenLabel(),
                            Infolists\Components\TextEntry::make('detail_value')
                                ->color('primary')
                                ->hiddenLabel()
                                ->weight(FontWeight::Bold),
                        ])->grid(2)
                        ->columns(2),
                    Infolists\Components\RepeatableEntry::make('asset.users')
                        ->label('Used by users')
                        // ->relationship('asset.users')
                        ->schema([
                            Infolists\Components\Split::make([
                                Infolists\Components\ImageEntry::make('avatar_url')
                                    ->grow(false)
                                    ->hiddenLabel()
                                    ->label('Avatar')
                                    ->height(32)
                                    ->circular()
                                    ->limitedRemainingText(size: 'lg'),
                                Infolists\Components\TextEntry::make('name')
                                    ->weight(FontWeight::Bold)
                                    ->size(TextEntrySize::Large)
                                    ->grow(false)
                                    ->hiddenLabel()
                                    ->icon('tabler-id-badge-2')
                                    ->iconColor('warning'),
                            ])->columns(2)
                        ])
                        ->contained(false)
                        ->grid(4),
                    // QrViewEntry::make('barcode'),
                ]),

                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('Asset Information')
                        ->icon('tabler-checkup-list')
                        ->description('Asset information of this inventory.')
                        ->schema([
                            Infolists\Components\TextEntry::make('asset.asset_code')
                                ->label('Asset Code')
                                ->color('danger')
                                ->copyable()
                                ->inlineLabel()
                                ->icon('tabler-id')
                                ->iconColor('warning')
                                ->weight(FontWeight::Bold)
                                ->size(TextEntrySize::Large),
                            Infolists\Components\TextEntry::make('asset.purchase_order')
                                ->label('Purchase Order')
                                ->inlineLabel()
                                ->weight(FontWeight::Bold),
                            Infolists\Components\TextEntry::make('asset.purchased_at')
                                ->date()
                                ->label('Purchased At')
                                ->inlineLabel()
                                ->weight(FontWeight::Bold),
                            Infolists\Components\TextEntry::make('asset.purchased_price')
                                ->currency('IDR')
                                ->label('Purchased Price')
                                ->inlineLabel()
                                ->weight(FontWeight::Bold),
                            Infolists\Components\TextEntry::make('asset.depreciation.method.name')
                                ->label('Depreciation Method')
                                ->inlineLabel()
                                ->weight(FontWeight::Bold),
                            Infolists\Components\TextEntry::make('asset.bookValue')
                                ->size(TextEntrySize::Large)
                                ->icon('tabler-moneybag')
                                ->iconColor('warning')
                                ->currency('IDR')
                                ->label('Book Value')
                                ->inlineLabel()
                                ->weight(FontWeight::Bold),
                            Infolists\Components\RepeatableEntry::make('asset.depreciation.bookValues')
                                ->label('Depreciations')
                                ->schema([
                                    Infolists\Components\TextEntry::make('value')
                                        ->label('Depreciation Value')
                                        ->icon('tabler-moneybag')
                                        ->iconColor('warning')
                                        ->currency('IDR')
                                        ->color('primary')
                                        ->weight(FontWeight::Bold),
                                    Infolists\Components\TextEntry::make('period')
                                        ->label('Depreciation Period')
                                        ->icon('tabler-calendar')
                                        ->iconColor('warning')
                                        ->color('danger')
                                        ->weight(FontWeight::Bold)
                                        ->date('M Y'),
                                ])
                                ->grid(4)
                                ->columnSpanFull(),
                        ])->columns(2),

                ])
                    ->hidden(fn(Model $record): bool => !$record->has('asset')->exists()),





            ])->columns(2);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
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
