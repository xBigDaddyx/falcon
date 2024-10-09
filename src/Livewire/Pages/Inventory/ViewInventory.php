<?php

namespace Xbigdaddyx\Falcon\Livewire\Pages\Inventory;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Filament\Infolists;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Xbigdaddyx\Falcon\Models\Inventory;

class ViewInventory extends Component implements HasForms, HasInfolists
{

    use InteractsWithInfolists;
    use InteractsWithForms;
    public Inventory $inventory;
    public Collection $specifications;
    public function mount($id)
    {
        $this->inventory = Inventory::findOrFail($id);
    }
    public function inventoryInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->inventory)
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
                        ])->columns([
                            'default' => 2,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 3,
                            'xl' => 3,
                            '2xl' => 3,

                        ]),

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
                        ])->columns([
                            'default' => 2,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 3,
                            'xl' => 3,
                            '2xl' => 3,
                        ]),

                ])
                    ->hidden(fn(Model $record): bool => !$record->has('asset')->exists()),
                Infolists\Components\Section::make('Specifications')
                    ->description("This section provides a detailed breakdown of the key specifications. Here, you'll find information on processors, memory, storage,
                    graphics, and connectivity options.")
                    ->icon('tabler-settings')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('specifications')
                            ->hiddenLabel()
                            ->schema([
                                Infolists\Components\TextEntry::make('detail_item')
                                    ->hiddenLabel(),
                                Infolists\Components\TextEntry::make('detail_value')
                                    ->color('primary')
                                    ->hiddenLabel()
                                    ->weight(FontWeight::Bold),
                            ])->grid(4)
                            ->columns(2)
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ])->columns(2);
    }

    public function render()
    {
        return view('falcon::livewire.view-inventory');
    }
}
