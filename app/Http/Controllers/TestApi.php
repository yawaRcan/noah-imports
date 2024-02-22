<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestApi extends Controller
{
      public function api(){

        $param =   
        [
        
        'carrier_id'=> 'dhl',               // the carrier code, you can find from https://app.kd100.com/api-management
        'tracking_number' => '9926933413',    // The tracking number you want to query
        'phone' => '',                        // Phone number
        'ship_from' => '',                    // City of departure
        'ship_to' => '',                      // Destination city
        'area_show' => 1,                     // 0: close (default); 1: return data about area_name, location, order_status_description
        'order' => 'desc'                     // Sorting of returned results: desc - descending (default), asc - ascending
        ];

    // Request Json
    $key='BpRXHMUFjCdp1609';
    $secret='e58ea39bb36643288a214aeff5c053f1';
    $json = json_encode($param, JSON_UNESCAPED_UNICODE);
    $signature = strtoupper(md5($json.$key.$secret));

    $url = 'https://www.kd100.com/api/v1/tracking/realtime';    // Real-time shipment tracking request address

        // echo 'request headers key: '.$key;
        // echo 'request headers signature: '.$signature;
        // echo 'request json: '.$json;

       $headers = array (
                'Content-Type:application/json',
                'API-Key:'.$key,
                'signature:'.$signature,
                'Content-Length:'.strlen($json)
       );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $data = json_decode($result, true);

    dd($data);

// echo 'Return data:';
// echo print_r($data);
//echo var_dump($data);

   



      }
  
    // public function api1(){

    //  $values=[
    //     'carrier_id'=> "dhl",
    //     "tracking_number" => "9926933413",
    //     "phone" => "95279527",
    //     "ship_from" => "Toronto, Canada",
    //     "area_show"=> 1,
    //     "ship_to" => "Los Angeles, CA, United States",
    //     "order" => "desc",
    //  ]; 

    
    // $data  ='{
    //     "carrier_id": "dhl",
    //     "tracking_number": "9926933413",
        
    // }';
    // $signature=strtoupper(MD5($data.'BpRXHMUFjCdp1609'.'e58ea39bb36643288a214aeff5c053f1'));
    
    // $url = 'https://www.kd100.com/api/v1/tracking/realtime';
    // $headers = [
       
    //     'Content-Type'=> 'application/json',
    //     'API-Key'=>'BpRXHMUFjCdp1609', 
    //     'signature'=> $signature
    // ];
    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
    
    // $response = curl_exec($ch);

    
    // if (curl_errno($ch)) {
    //     // Handle cURL error
    //     dd($ch);
    //     return 'cURL Error: ' . curl_error($ch);
    // }
    
    // curl_close($ch);
    
    // return $response;
    //          }

    }

