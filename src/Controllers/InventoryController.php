<?php

namespace Xbigdaddyx\Falcon\Controllers;

use Illuminate\Routing\Controller;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Xbigdaddyx\Falcon\Models\Inventory;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class InventoryController extends Controller
{
    public function show($id)
    {
        $invent = Inventory::findOrFail($id);
        // return view('falcon::pages.inventory.show', ['item' => $invent]);
    }
}
