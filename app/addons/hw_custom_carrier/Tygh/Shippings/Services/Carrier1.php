<?php

namespace Tygh\Shippings\Services;

use Tygh\Shippings\IService;
class Carrier1 implements IService{
    public function prepareData($shipping_info){}
    public function allowMultithreading(){}
    public function getRequestData(){}
    public function getSimpleRates(){}
    public function processErrors($result){}
    public function processResponse($response){}
    public function processRates($result){}

    public static function getInfo(){
        return array(
            'name' => 'Herve',
            'tracking_url' => 'google/herve'
        );
    }
}