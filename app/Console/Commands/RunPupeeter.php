<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunPupeeter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-pupeeter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {

        $amazonUrl = 'url';
        $arg = $amazonUrl;
        $file = "node app\NodeJs\index.js";
        $amazon = '';
        exec($file, $output, $error_code);
        dd($output);


    }
}
