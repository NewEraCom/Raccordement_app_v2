<?php

namespace App\Console\Commands;

use App\Mail\RecapMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendRecap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:recap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a daily recap to the chef';

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
        Mail::to(['a.qandoussi@neweracom.ma','a.elamrani@neweracom.ma','f.smaili@neweracom.ma','h.jlidat@neweracom.ma','a.zaoui@neweracom.ma'])->send(new RecapMail());
        return 1;
    }
}
