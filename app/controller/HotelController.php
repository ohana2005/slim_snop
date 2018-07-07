<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 18:09
 */
class HotelController extends BaseController
{
    public function search($request, $response, $args){
        $this->container['service']->init($args);
        return $this->view('hotel/search.html.php', [
            'hotel' => $this->container['hotel']->getHotel(),
            'search' => $this->container['search']->getDataValues()
        ]);
    }

    public function rooms($request, $response, $args)
    {
        $this->container['service']->init($args);
        $this->container['search']->init($_GET);


        $Rooms = $this->container['hotel']->findRooms();
        $this->container['order']->setRooms($Rooms);
        return $this->view('hotel/rooms.html.php', [
            'hotel' => $this->container['hotel']->getHotel(),
            'search' => $this->container['search']->getDataValues(),
            'Rooms' => $Rooms
        ]);
    }

    public function roombook($request, $response, $args){
        $this->container['service']->init($args);
        $this->container['order']->addToOrder($args['key']);
        return $this->snopGoTo($response, 'checkout', $args);
    }

    public function checkout($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/checkout.html.php', [
            'hotel' => $this->container['hotel']->getHotel(),
            'search' => $this->container['search']->getDataValues(),
            'order' => $this->container['order']->getOrder()
        ]);
    }

    public function checkoutPost($request, $response, $args){
        $this->container['service']->init($args);
        $responseData = $this->container['order']->create($_POST['order']);
        if($responseData['type'] == 'success'){
            return $this->snopGoTo($response, 'thank', $args, ['hash' => $responseData['bookingHash'], 'bookingId' => $responseData['bookingId']]);
        }else{
            if($responseData['errorcode'] == 2){
                return $this->snopGoTo($response, 'error_occupied', $args);
            }else{
                return $this->snopGoTo($response, 'error_technical', $args);
            }
        }
    }

    public function thank($request, $response, $args)
    {
        $this->container['service']->init($args);
        $Booking = $this->container['hotel']->getBooking($_GET['bookingId'], $_GET['hash']);
        if(!$Booking){
            return $response->withRedirect($this->container->get('router')->pathFor('error_technical', $args));
        }
        return $this->view('hotel/thank.html.php', [
            'hotel' => $this->container['hotel']->getHotel(),
            'booking' => $Booking
        ]);
    }


    protected function snopGoTo($response, $step, $args, $params = []){
        if($this->isWidget()){
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode([
                    'step' => $step,
                    'params' => http_build_query($params)
                ]));
        }else{
            $sParams = !empty($params) ? '?' . http_build_query($params) : '';
            return $response->withRedirect($this->container->get('router')->pathFor($step, $args) . $sParams);
        }
    }
}