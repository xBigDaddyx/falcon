<?php

namespace Xbigdaddyx\Falcon\Controllers;

use Illuminate\Routing\Controller;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Xbigdaddyx\Falcon\Models\Inventory;

class BarcodeController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return Pdf::view('falcon::pdf.barcode', ['inventories' => $inventories])->save('/home/xbigdaddyx/projects/teresa/public/barcode.pdf');
    }
}
