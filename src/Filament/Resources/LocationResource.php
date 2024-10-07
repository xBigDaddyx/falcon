<?php

namespace Xbigdaddyx\Falcon\Filament\Resources;

use Xbigdaddyx\Falcon\Filament\Resources\LocationResource\Pages;
use Xbigdaddyx\Falcon\Filament\Resources\LocationResource\RelationManagers;
use Xbigdaddyx\Falcon\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'tabler-building';
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['company']);
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'company.name', 'company.short_name'];
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
        return trans('falcon::falcon.resource.location.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('falcon::falcon.resource.location.label');
    }

    public static function getLabel(): string
    {
        return trans('falcon::falcon.resource.location.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('falcon::falcon.resource.location.group');
    }

    public function getTitle(): string
    {
        return trans('falcon::falcon.resource.location.title.resource');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                // \Dotswan\MapPicker\Fields\Map::make('location')
                //     ->live()
                //     ->label('Location')
                //     ->columnSpanFull()
                //     ->afterStateUpdated(function (Set $set, ?array $state): void {
                //         $set('latitude', $state['lat']);
                //         $set('longitude', $state['lng']);
                //     })
                //     // ->afterStateHydrated(function ($state, $record, Set $set): void {
                //     //     $set('location', ['lat' => $record->latitude, 'lng' => $record->longitude]);
                //     // })
                //     // ->extraStyles([
                //     //     'min-height: 150vh',
                //     //     'border-radius: 50px'
                //     // ])
                //     ->liveLocation(true, true, 5000)
                //     ->showMarker()
                //     ->markerColor("#22c55eff")
                //     ->showFullscreenControl()
                //     ->showZoomControl()
                //     ->draggable()
                //     ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                //     ->zoom(15)
                //     ->detectRetina()
                //     ->showMyLocationButton()
                //     ->extraTileControl([])
                //     ->extraControl([
                //         'zoomDelta'           => 1,
                //         'zoomSnap'            => 2,
                //     ]),
                // Forms\Components\TextInput::make('latitude')
                //     ->hiddenLabel()
                //     ->readOnly(),

                // Forms\Components\TextInput::make('longitude')
                //     ->hiddenLabel()
                //     ->readOnly(),
                // Forms\Components\TextInput::make('deleted_by')
                //     ->numeric(),
                // Forms\Components\TextInput::make('created_by')
                //     ->numeric(),
                // Forms\Components\TextInput::make('updated_by')
                //     ->numeric(),
                // Forms\Components\Select::make('company_id')
                //     ->relationship('company', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('uuid')
                //     ->label('UUID'),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('company.logo'),
                // Tables\Columns\TextColumn::make('latitude')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('longitude')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('deleted_by')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_by')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('updated_by')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('company_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageLocations::route('/'),
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
