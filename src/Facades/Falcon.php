<?php

namespace XBigDaddyx\Falcon\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \XBigDaddyx\Falcon\Falcon
 */
class Falcon extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \XBigDaddyx\Falcon\Falcon::class;
    }
}
