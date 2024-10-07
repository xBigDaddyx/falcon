<?php

namespace Xbigdaddyx\Falcon\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Xbigdaddyx\Falcon\Events\MethodAssigned;

class CalculateDepreciation
{
    public function __construct()
    {
        //
    }

    public function handle(MethodAssigned $event)
    {
        Artisan::call('falcon:book-value ' . $event->asset->uuid . ' ' . $event->method->uuid);
    }
}
