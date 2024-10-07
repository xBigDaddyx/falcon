<?php

namespace Xbigdaddyx\Falcon\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xbigdaddyx\Falcon\Falcon
 */
class Falcon extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Xbigdaddyx\Falcon\Falcon::class;
    }
}
