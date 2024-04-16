<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TestController extends Controller
{
    
    
    public function test100api()
    {
        //generate timestamp & sign
        $params = array();
        $params['filter_year'] = '2023';
        $params['filter_month'] = '9';
        $timestamp = time();
        $sign = $this->generateSign($params, $timestamp);
        
        echo $timestamp."<br />";
        echo $sign;
    }


    public function generateSign($params, $timestamp)
    {
        //排序
        ksort($params);

        // base64序列化
        $str    = base64_encode(json_encode($params));
        $secret = 'base64:7PDcMQxymTtUqxy1PubJe+P3xf8mv0t9LgvX58+MVtk=';

        return hash('sha256', $timestamp . $str . $secret);
    }

    
}
