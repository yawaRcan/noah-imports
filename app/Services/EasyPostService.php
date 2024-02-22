<?php

namespace App\Services;

use Exception;
use App\Services\EasyPost;

class EasyPostService
{
    protected $key;
    protected $client;
    public $template = [];

    public function __construct()
    {
        // You can set your EasyPost API key here or retrieve it from a configuration file
        // Test API: EZTK9caa472bba5f4c07a781143975d364bab573m1GGkySGB0Yc5rmd7Q
        // Production API: EZAK9caa472bba5f4c07a781143975d364baW8WxGW68C4Jq8i13PJJRIA
        
        $this->key = 'EZTK9caa472bba5f4c07a781143975d364bab573m1GGkySGB0Yc5rmd7Q';
        $this->client = new \EasyPost\EasyPostClient($this->key); 
    }

    // Create a label in EasyPost and optionally send a notification
    public function createLabel($status = true)
    {
        if ($status) {
            try { 

                // Create the label
                $tracking = $this->client->tracker->create([
                    'tracking_code' => $this->template['external_tracking'],
                    'carrier' => $this->template['carrier'] 
                ]);

                return ['message' => $tracking, 'response' => 200];
            } catch (Exception $exc) {
                return ['message' => $exc->getMessage(), 'response' => 400];
            }
        }

        return false;
    } 

    // View label details
    public function viewLabel($id)
    {
        try {
            $shipment = $this->client->tracker->retrieve($id); 

            return [
                'full_data' => $shipment,
                'response' => 200, 
            ];
        } catch (Exception $exc) {
            return ['message' => $exc->getMessage(), 'response' => 400];
        }
    } 
} 
