<?php

namespace Xbigdaddyx\Falcon\Filament\Resources;

use Filament\Actions\Action;
use Xbigdaddyx\Falcon\Filament\Resources\AgeResource\Pages;
use Xbigdaddyx\Falcon\Filament\Resources\AgeResource\RelationManagers;
use Xbigdaddyx\Falcon\Models\Age;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class AgeResource extends Resource
{
    protected static ?string $model = Age::class;

    protected static ?string $recordTitleAttribute = 'estimate_age';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'tabler-calendar';
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category', 'subCategory']);
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['estimate_age', 'category.name', 'subCategory.name'];
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
        return $record->estimate_age;
    }
    public static function getNavigationLabel(): string
    {
        return trans('falcon::falcon.resource.age.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('falcon::falcon.resource.age.label');
    }

    public static function getLabel(): string
    {
        return trans('falcon::falcon.resource.age.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('falcon::falcon.resource.age.group');
    }

    public function getTitle(): string
    {
        return trans('falcon::falcon.resource.age.title.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('estimate_age')
                    ->numeric()
                    ->label('Estimate Age (Year)')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category_id')
                    ->live()
                    ->relationship('category', 'name')
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name} ( {$record->description} )"),
                Forms\Components\Select::make('sub_category_id')
                    ->live()
                    ->relationship('subCategory', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                        if ($get('category_id')) {
                            return $query->where('category_id', $get('category_id'));
                        }
                        return $query;
                    })
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name} ( {$record->description} )"),
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
                Tables\Columns\TextColumn::make('estimate_age')
                    ->label('Lifespan (Year)'),
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
            'index' => Pages\ManageAges::route('/'),
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
