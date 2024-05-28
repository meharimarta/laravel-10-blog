<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MehariMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:mehari
                            {email: mails to this webApp developer mehari mehari@protech.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $totalUnits = 10;
        $this->output->progressStart($totalUnits);
        for ($i = 0; $i < $totalUnits; $i++) {
            sleep(1);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $this-> info("Mailed to mehari successfully");
    }
}
