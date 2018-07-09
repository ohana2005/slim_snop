<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 7/7/18
 * Time: 21:50
 */
class PaymentController extends BaseController
{
    public function success($request, $response, $args){
        $this->container['service']->init($args);
        $Booking = $this->container['hotel']->getBooking($_GET['objectid'], $_GET['hash']);
        if(!$this->checkSignature($Booking, $_GET['signature'])){
            die('signature is wrong');
        }
        $res = $this->container['api']->updateBookingStatus($Booking, 'paid');
        if($res['type'] == 'error'){
            die($res['message']);
        }
        $sParams = '?' . http_build_query(['hash' => $Booking['hash'], 'bookingId' => $Booking['id']]);
        return $response->withRedirect($this->container->get('router')->pathFor('thank', $args) . $sParams);
    }

    public function cancel($request, $response, $args){
        $this->container['service']->init($args);
        $Booking = $this->container['hotel']->getBooking($_GET['objectid'], $_GET['hash']);
        if(!$this->checkSignature($Booking, $_GET['signature'])){
            die('signature is wrong');
        }
        $res = $this->container['api']->updateBookingStatus($Booking, 'cancelled');
        if($res['type'] == 'error'){
            die($res['message']);
        }
        $sParams = '?' . http_build_query(['hash' => $Booking['hash'], 'bookingId' => $Booking['id']]);
        return $response->withRedirect($this->container->get('router')->pathFor('thank', $args) . $sParams);
    }

    public function failure($request, $response, $args){
        $this->container['service']->init($args);
        print_r($_GET);die;
    }

    protected function checkSignature($Booking, $signature){
        $client_key = $this->container['hotel']->getConfig('payment_client_key');
        $client_secret = $this->container['hotel']->getConfig('payment_client_secret');
        $currency = $this->container['hotel']->getConfig('currency');
        $bSig = sha1($client_key . $client_secret . $Booking['price'] . $currency);
        return $bSig == $signature;
    }
}