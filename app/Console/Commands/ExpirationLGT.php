<?php

namespace App\Console\Commands;

use App\Http\Controllers\LogisticController;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpirationLGT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expirationlgt:cron';

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
        Log::info("Execution : "); //  logger dans storage/log/laravel.php
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.SERVER_URL")."/logistique_securite/sendEmailExpirations");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }
}
