<?php

namespace Xbigdaddyx\Falcon\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xbigdaddyx\Falcon\Models\Asset;

class AssetCreated
{
    use Dispatchable, SerializesModels;

    public $asset;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }
}
