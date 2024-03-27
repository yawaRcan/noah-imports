<?php

namespace App\Listeners;

use App\Events\Scrapping;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\Process\Process;

class ProcessScrapping
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Scrapping $event): void
    {
        // dd($event->url);
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '700M');
        $url = 'https://www.amazon.com/Wrangler-Authentics-Womens-Jacket-Weathered/dp/B012OV0Q4M/ref=sr_1_2?_encoding=UTF8&content-id=amzn1.sym.b4114be9-6d3d-4aed-8b31-fcbf38a83486&crid=28AAZ2JDZCYX1&dib=eyJ2IjoiMSJ9.zMBgibmsEX2xEv-ybj5QzREVc6X6-HzSWFVevXsfFIS0PA3JMIgRusR8GQ_p0yunaPNqeF2DVbscJlESA9nueVdFZzu7T1EjuMPPdd68zZOk5br1Ei3-TZmww_3Mq-yFKE-0mQLosORHdCqUMTXJQV7BB-y0rAddxckQMNF7G9YKMpqxQp94u_GvX4prv48tQX-vRMKog31-eyCQ4YgYTawFR0Z_GodZ4bIFCs3IOtZ0y6Wg1OcKZ2eqrDuS0B6QdchlFsCAasw1tCIkMSURZn5Dy88s2sJXb5-iWIPqEsY.HI1Xg7GSESp9D74Cbz27em79V189SuiEkT5ah2fhOpk&dib_tag=se&keywords=Spring+Jackets&pd_rd_r=b9b29b6d-e0f8-4d98-9446-a967ae274355&pd_rd_w=6Kv9a&pd_rd_wg=K8Wgg&pf_rd_p=b4114be9-6d3d-4aed-8b31-fcbf38a83486&pf_rd_r=DDSRGTG3GMDAPZEP5264&qid=1710998396&sprefix=spring+jackets%2Caps%2C140&sr=8-2';

        if ($event->eventName == 'Amazone') {
            $my_execute = 'node C:\wamp64\www\noah-imports\app\NodeJs\index.js ' . $url;
            $output = exec($my_execute);
            $imageUrls = json_decode($output, true);
            dd($imageUrls);

        }
    }
}
