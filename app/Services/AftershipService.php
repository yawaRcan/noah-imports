<?php

namespace App\Services;
 
use Exception;

class AftershipService
{ 

    protected  $key;
   
    public  $template = []; 
    
    protected  function init()
    { 
        $this->key = general_setting('aftership')->aftership_api; 
        return (object) [
            'couriers' => new \AfterShip\Couriers($this->key),
            'trackings' => new \AfterShip\Trackings($this->key),
            'last_check_point' => new \AfterShip\LastCheckPoint($this->key),
            'notifications' => new \AfterShip\Notifications($this->key)
        ];
    } 

        //create label to aftership account
        public  function createLabel($status = true, $waybill = null, $notification = false)
        {
            if($status)
            { 
                try {
                    if($notification){
                      
                        $this->createNotification($this->template['slug'], $waybill);
                    }
                    //return the success message of
                   
                    return ['message' => $this->init()->trackings->create($waybill, $this->template), 'response' => 200];
                } catch (Exception $exc) {
                    return ['message' => $exc->getMessage(), 'response' => 400];
                }
            }
            return false;
        }

            //create label notification 
    public  function createNotification($slug, $waybill)
    {
        try {
            return [
                'message' => $this->init()->notifications->create($slug, $waybill, ['emails' => $this->template['emails'] ]), 
                'response' => 200
            ];
        } catch (Exception $exc) {
            return ['message' => $exc->getMessage(), 'response' => 400];
        }
    }

        //view label
        public  function viewLabel($slug, $waybill)
        { 
            try {
             
                return [
                    'full_data' => $this->init()->trackings->get($slug, $waybill)['data']['tracking'],
                    'response' => $this->init()->trackings->get($slug, $waybill)['meta']['code'],
                    'data' => [
                        'shipment_type' => $this->init()->trackings->get($slug, $waybill)['data']['tracking']['shipment_type'],
                        'tag' => $this->init()->trackings->get($slug, $waybill)['data']['tracking']['tag'],
                        'checkpoints' => sort_array('krsort', $this->init()->trackings->get($slug, $waybill)['data']['tracking']['checkpoints'])
                    ]
                ];
            } catch (Exception $exc) {
                return ['message' => $exc->getMessage(), 'response' => 400];
            }
        }

            //get label notification
            public  function getNotification($slug, $waybill)
            {
                try {
                    return ['message' => $this->init()->notifications->get($slug, $waybill), 'response' => 200];
                } catch (Exception $exc) {
                    return ['message' => $exc->getMessage(), 'response' => 400];
                }
            }
            
            //delete label
            public  function deleteLabel($slug, $waybill)
            {
                try {
                    return ['message' => $this->init()->trackings->delete($slug, $waybill), 'response' => 200];
                } catch (Exception $exc) {
                    return ['message' => $exc->getMessage(), 'response' => 400];
                }
            }
 

}