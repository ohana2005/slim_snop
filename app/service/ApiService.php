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
        $url = API_HOST . "/booking/create";
        $authToken = 'Bearer ' . md5(microtime());
        return $this->curlRequest($url, $data, $authToken);
    }

    protected function curlRequest($url, $data, $authToken)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authToken,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        // Send the request
        $response = curl_exec($ch);
        if ($response === FALSE) {
            die(curl_error($ch));
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);
        return $responseData;
    }

    public function payBooking($Booking){
        $client_key = $this->container['hotel']->getConfig('payment_client_key');
        $client_secret = $this->container['hotel']->getConfig('payment_client_secret');
        $currency = $this->container['hotel']->getConfig('currency');
        $signature = sha1($Booking['price'] . $currency . $client_key . $client_secret);
        $data = [
            'client_key' => $client_key,
            'objectid' => $Booking['id'],
            'params' => 'hash=' . $Booking['hash'],
            'signature' => $signature,
            'sum' => $Booking['price'],
            'currency' => $currency,
            'product' => $Booking['room_category_name'] . '/' . $Booking['package_name'],
            'description' => $Booking['guest_name'] . ', #' . $Booking['id'],
            'url_success' => $this->generateUrl('payment_success', true),
            'url_cancel' => $this->generateUrl('payment_cancel', true),
            'url_failure' => $this->generateUrl('payment_cancel', true),
        ];
        $authToken = 'Bearer ' . md5(microtime());
        $url = PAYMENT_API_HOST . '/transaction/new';
        return $this->curlRequest($url, $data, $authToken);
    }


    public function updateBookingStatus($Booking, $status)
    {
        $url = API_HOST . "/booking/updateStatus";
        $data = [
            'id' => $Booking['id'],
            'hash' => $Booking['hash'],
            'status' => $status
        ];
        $authToken = 'Bearer ' . md5(microtime());
        return $this->curlRequest($url, $data, $authToken);

    }


}