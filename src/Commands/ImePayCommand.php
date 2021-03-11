<?php

namespace Asdh\ImePay\Commands;

use Illuminate\Console\Command;

class ImePayCommand extends Command
{
    public $signature = 'imepay';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
