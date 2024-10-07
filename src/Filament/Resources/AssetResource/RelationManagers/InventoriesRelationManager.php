<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\AssetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;
use Xbigdaddyx\Falcon\Filament\Resources\InventoryResource;

class InventoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'inventories';

    public function form(Form $form): Form
    {
        return InventoryResource::form($form);
    }
    // public function infolist(Infolist $infolist): InfoList
    // {
    //     return InventoryResource::infolist($infolist);
    // }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
                // Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make(),
                Tables\Actions\ViewAction::make()
                    ->modalWidth(MaxWidth::MaxContent),
                // Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
        // ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
        //     SoftDeletingScope::class,
        // ]));
    }
}
