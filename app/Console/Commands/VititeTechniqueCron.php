<?php

namespace App\Console\Commands;

use App\Http\Controllers\LogisticController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VititeTechniqueCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitetechnique:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron email pour les visites techniques expirées';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron is working fine!"); //  logger dans storage/log/laravel.php
        //return 0; // par defaut
    }
}
