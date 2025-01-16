<?php

namespace App\Console\Commands;

use App\Services\web\ClientSavService;
use Illuminate\Console\Command;

class ImportSavAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importation-sav:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Sav Clients from mail every hour';

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
        ClientSavService::ImportAuto();
        return 1;
    }
}
