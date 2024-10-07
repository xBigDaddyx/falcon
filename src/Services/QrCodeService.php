<?php

namespace Xbigdaddyx\Falcon\Services;

use Illuminate\Support\Facades\Http;

class QrCodeService
{
    public function generateQrCode($url)
    {
        // Consumimos la API de QR Server para generar el código
        $response = Http::get('https://api.qrserver.com/v1/create-qr-code/', [
            'size' => '150x150',
            'data' => $url
        ]);

        return $response->body();
    }
}
