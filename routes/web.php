<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Xbigdaddyx\Falcon\Controllers\BarcodeController;
use Xbigdaddyx\Falcon\Controllers\InventoryController;
use Xbigdaddyx\Falcon\Livewire\Pages\Inventory\ViewInventory;

Route::middleware(['web', 'auth'])->prefix('falcon')->group(function () {
    Route::get('/page/inventory/{id}', [InventoryController::class, 'show'])->name('falcon.page.inventory.show.release');
    Route::get('/barcode/print', [BarcodeController::class, 'index'])->name('falcon.barcode.pdf.release');
    Route::get('/page/test/{id}', ViewInventory::class)->name('falcon.page.test.view.release');
});
