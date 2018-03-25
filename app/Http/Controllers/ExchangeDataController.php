<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ExchangeDataController extends Controller
{
    public function index(){

       $response =  SELF::_get_data_from_url("https://api.coinmarketcap.com/v1/ticker/");

        return $response;
    }

    public function get_currency($coin_name){

        $response =  SELF::_get_data_from_url("https://api.coinmarketcap.com/v1/ticker/".$coin_name."/");

        return $response;
    }

    public function convert_currency($coin_name,$convert_to){

        $response =  SELF::_get_data_from_url("https://api.coinmarketcap.com/v1/ticker/".$coin_name."/?convert=".$convert_to);

        return $response;
    }

    public function latest_news(){

        $response = SELF::_get_data_from_url("https://www.coindesk.com/",false);

        return $response;
    }

    private static function _get_data_from_url($url,$json=true){
        $_init = curl_init($url);

        curl_setopt($_init, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($_init, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($_init);
        curl_close($_init);

        if(!$json){
            return $response;
        }

        return json_decode($response);
    }

    
}
