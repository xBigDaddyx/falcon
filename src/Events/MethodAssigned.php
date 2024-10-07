<?php

namespace Xbigdaddyx\Falcon\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xbigdaddyx\Falcon\Models\Asset;
use Xbigdaddyx\Falcon\Models\Method;

class MethodAssigned
{
    use Dispatchable, SerializesModels;

    public $asset;
    public $method;

    public function __construct(Asset $asset, Method $method)
    {
        $this->asset = $asset;
        $this->method = $method;
    }
}
