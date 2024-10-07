<?php

namespace Xbigdaddyx\Falcon\Filament\Resources\AssetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return \Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar_url')
                        ->label('Avatar')
                        ->grow(false)
                        ->circular(),
                    Tables\Columns\TextColumn::make('name')
                        ->sortable()
                        ->searchable()
                        ->grow(false)
                        ->label(trans('fuse::fuse.resource.user.name')),
                    Tables\Columns\IconColumn::make('email_verified_at')

                        ->boolean()
                        ->sortable()
                        ->searchable()
                        ->label(trans('fuse::fuse.resource.user.email_verified_at')),
                ]),
                Tables\Columns\Layout\Panel::make([
                    Tables\Columns\TextColumn::make('email')
                        ->color('primary')
                        ->icon('heroicon-o-envelope')
                        ->sortable()
                        ->searchable()
                        ->label(trans('fuse::fuse.resource.user.email'))
                        ->grow(false),
                    Tables\Columns\TextColumn::make('phone')
                        ->icon('heroicon-o-phone')
                        ->color('secondary')
                        ->sortable()
                        ->grow(false),
                    Tables\Columns\TextColumn::make('gender')
                        ->formatStateUsing(function (string $state) {
                            if ($state === 'm') {
                                return "Male";
                            }
                            return "Female";
                        })
                        ->icon('heroicon-o-user-group')
                        ->sortable()
                        ->grow(false),
                    Tables\Columns\TextColumn::make('address')
                        ->icon('heroicon-o-building-storefront')
                        ->sortable()
                        ->grow(false),
                    Tables\Columns\TextColumn::make('roles.name')
                        ->icon('heroicon-o-star')
                        ->grow(false),
                ])->collapsible(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\ViewAction::make()
                    ->modalWidth(MaxWidth::MaxContent),
                // Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
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
