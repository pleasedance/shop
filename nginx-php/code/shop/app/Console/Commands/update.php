<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $successNum;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    private function console($message){
        echo date("H:i:s").$message."\n";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    }
    
    

}
