<?php

namespace App\Console\Commands;

use App\Models\TechnicienLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleaning logs record older than 2 days';

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
        TechnicienLog::whereDate('created_at', '<', now()->subDays(2))->delete();
        Log::chanel('error')->error('Cleaning logs record older than 2 days');
        return 1;
    }
}
