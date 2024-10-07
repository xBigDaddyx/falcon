<?php

namespace Xbigdaddyx\Falcon\Filament\Resources;

use Filament\Actions\Action;
use Xbigdaddyx\Falcon\Filament\Resources\SubCategoryResource\Pages;
use Xbigdaddyx\Falcon\Filament\Resources\SubCategoryResource\RelationManagers;
use Xbigdaddyx\Falcon\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;
    protected static bool $isScopedToTenant = false;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'tabler-list-tree';
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'category.name'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {

        return [
            'Description' => $record->description,
            'Category' => $record->category->name,

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
        return trans('falcon::falcon.resource.subcategory.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('falcon::falcon.resource.subcategory.label');
    }

    public static function getLabel(): string
    {
        return trans('falcon::falcon.resource.subcategory.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('falcon::falcon.resource.subcategory.group');
    }

    public function getTitle(): string
    {
        return trans('falcon::falcon.resource.subcategory.title.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                \TomatoPHP\FilamentIcons\Components\IconPicker::make('icon')
                    ->default('heroicon-o-academic-cap')
                    ->label('Icon'),
                \Awcodes\Palette\Forms\Components\ColorPickerSelect::make('color')
                    ->storeAsKey()
                    ->colors([
                        'danger' => Color::Red,
                        'gray' => Color::Zinc,
                        'info' => Color::Blue,
                        'success' => Color::Green,
                        'warning' => Color::Amber,
                        'primary' => '#0C6478',
                    ])
                    ->withBlack(swap: '#111111')
                    ->withWhite(swap: '#f5f5f5'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name'),

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
                // Tables\Columns\TextColumn::make('uuid')
                //     ->label('#'),
                Tables\Columns\TextColumn::make('name')
                    ->badge()
                    ->color(fn(Model $record): string => $record->color ?? 'primary')
                    ->searchable(),
                Tables\Columns\IconColumn::make('icon')
                    ->color(fn(Model $record): string => $record->color ?? 'primary')
                    ->icon(fn(string $state): string => match ($state) {
                        $state => $state,
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.name')
                    ->description(fn(Model $record): string => $record->category->description)
                    ->badge()
                    ->icon(fn(Model $record): string => $record->category->icon ?? 'tabler-file')
                    ->color(fn(Model $record): string => $record->category->color ?? 'primary'),
                // Tables\Columns\TextColumn::make('deleted_by')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_by')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('updated_by')
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
            'index' => Pages\ManageSubCategories::route('/'),
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