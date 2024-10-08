<?php

namespace Xbigdaddyx\Falcon\Filament\Resources;


use Xbigdaddyx\Falcon\Filament\Resources\AssetResource\Pages;
use Xbigdaddyx\Falcon\Filament\Resources\AssetResource\RelationManagers;
use Xbigdaddyx\Falcon\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;
use Xbigdaddyx\Falcon\Models\Category;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $recordTitleAttribute = 'asset_code';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'tabler-device-imac';
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['company']);
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['asset_code', 'purchased_price', 'purchased_at', 'company.name', 'company.short_name'];
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
        return $record->asset_code;
    }
    public static function getNavigationLabel(): string
    {
        return trans('falcon::falcon.resource.asset.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('falcon::falcon.resource.asset.label');
    }

    public static function getLabel(): string
    {
        return trans('falcon::falcon.resource.asset.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('falcon::falcon.resource.asset.group');
    }

    public function getTitle(): string
    {
        return trans('falcon::falcon.resource.asset.title.resource');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Group::make([
                    Forms\Components\Section::make('General Information')
                        ->schema([
                            Forms\Components\TextInput::make('asset_name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('asset_code')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('category_id')
                                ->label('Asset Type')
                                ->relationship('category', 'finance_asset_type')
                                ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->finance_asset_type} ( <span class='text-warning-500'>{$record->finance_asset_account}</span> )")
                                ->searchable(['finance_asset_type', 'finance_asset_account'])
                                ->allowHtml(),
                        ])->columns(2),
                    Forms\Components\Section::make('Purchase Information')
                        ->schema([
                            Forms\Components\TextInput::make('purchased_price')
                                ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                                ->required(),
                            Forms\Components\DatePicker::make('purchased_at')
                                ->required(),
                            Forms\Components\TextInput::make('purchase_order')
                                ->maxLength(255),
                        ])->columns(2),

                ]),
                Forms\Components\Group::make([
                    Forms\Components\FileUpload::make('attachment')

                        ->multiple(),
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
                Tables\Columns\TextColumn::make('asset_name')
                    ->iconColor('primary')
                    ->icon('tabler-pencil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asset_code')
                    ->copyable()
                    ->weight(FontWeight::Bold)
                    ->iconColor('primary')
                    ->icon('tabler-id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchased_price')
                    ->iconColor('primary')
                    ->icon('tabler-moneybag')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchased_at')
                    ->iconColor('primary')
                    ->icon('tabler-calendar')
                    ->dateTime('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_order')
                    ->iconColor('primary')
                    ->icon('tabler-file')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.finance_asset_type')
                    ->label('Type')
                    ->icon(fn(Model $record): string => $record->category->icon ?? 'tabler-file')
                    ->color(fn(Model $record): string => $record->category->color ?? 'primary'),
                Tables\Columns\TextColumn::make('category.finance_asset_account')
                    ->label('Account')
                    ->icon('tabler-file')
                    ->color(fn(Model $record): string => $record->category->color ?? 'primary'),
                Tables\Columns\TextColumn::make('company.name')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                \AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction::make('export'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('export'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\InventoriesRelationManager::class,
            RelationManagers\DepreciationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
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
