<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class IsDown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:is-down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the app is currently in hard maintenance mode';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (App::isDownForMaintenance()) {
            $this->info(true);
        } else {
            $this->info(false);
        }
    }
}
