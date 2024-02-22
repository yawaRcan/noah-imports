<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if (!function_exists('general_setting')) {
    function general_setting($config)
    {
        $setting =  Setting::first();

        return $setting->$config;
    }
}

if (!function_exists('notificationsCount')) {
    function notificationsCount($type)
    {
        $count = Auth::user()->unreadNotifications->whereIn('NType',$type)->count();
        return $count;

    }
}


if (!function_exists('sort_array')) {
    function sort_array($type, $arry)
    {
        switch ($type) {
            case 'rsort':
                rsort($arry);
                return $arry; //sort arrays in descending order
                break;

            case 'asort':
                asort($arry);
                return asort($arry); //sort associative arrays in ascending order, according to the value
                break;

            case 'ksort':
                ksort($arry);
                return $arry; //sort associative arrays in ascending order, according to the key
                break;

            case 'arsort':
                arsort($arry);
                return $arry; //sort associative arrays in descending order, according to the value
                break;

            case 'krsort':
                krsort($arry);
                return $arry; //sort associative arrays  descending order, according to the value
                break;

            default:
                sort($arry);
                return $arry; //sort arrays in descending order
                break;
        }
    }
}

if (!function_exists('shortCodeReplacer')) {

    function shortCodeReplacer($shortCode, $replace_with, $template_string)
    {
        return str_replace($shortCode, $replace_with, $template_string);
    }
}

if (!function_exists('shortCodeBodyReplacer')) {

    function shortCodeBodyReplacer( $body = null , $shortCodes = null , $notifiable = null  )
    {
        $name =  $notifiable->first_name.' '.$notifiable->last_name;
        
      
        
        $publicPath =    storage_path();
       
        $modifiedUrl = str_replace("/home/trusuzua/", "http://",  $publicPath);
       
        
        $body = shortCodeReplacer("[URL]", $modifiedUrl, $body);
        $body = shortCodeReplacer("[URL_LINK]",'company/logo.png', $body);
        $body = shortCodeReplacer("[name]", $name, $body); 
        $body = shortCodeReplacer("[SITE_NAME]", general_setting('configuration')->site_name, $body); 
        $body = shortCodeReplacer("[site_url]", url('/'), $body);
        $body = shortCodeReplacer("[site_url_text]", general_setting('configuration')->site_name, $body);
  
   
       
        foreach ($shortCodes as $code => $value) {
           
         
              $body = shortCodeReplacer('[' . $code . ']', $value, $body);
            
          
        }
         Log::info($body);
        return $body;
    }
}

if (!function_exists('checkDeliveryStatus')) {
    function checkDeliveryStatus($status)
    {
        if($status=='Delivered'){
            return 'delivered';
        }elseif($status=='In transit'){
            return 'in-transit';
        }elseif($status=='Pending customs clearance'){
            return 'pending';
        }
        elseif($status=='Customs clearance completed'){
            return '';
        }
        elseif($status=='Transshipment'){
            return 'in-transit';
        }
        elseif($status=='Accepted'){
            return 'delivered';
        }else{
            return '';
        } 

    }
}



