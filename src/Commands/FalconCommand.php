<?php

namespace Xbigdaddyx\Falcon\Commands;

use Illuminate\Console\Command;

class FalconCommand extends Command
{
    public $signature = 'falcon';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
