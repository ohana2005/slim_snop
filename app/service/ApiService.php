<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/27/18
 * Time: 21:59
 */
class ApiService extends BaseService
{
    public function saveBooking($data){
        $url = "http://test.test/testjson.php";
        $ch = curl_init($url);
        $authToken = 'Bearer ' . md5(microtime());
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$authToken,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
// Send the request
        $response = curl_exec($ch);
        if($response === FALSE){
            die(curl_error($ch));
        }

// Decode the response
        $responseData = json_decode($response, TRUE);
        return $responseData;
    }
}