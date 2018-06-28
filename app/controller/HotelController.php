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

        return $response->withRedirect($this->container->get('router')->pathFor('checkout', $args));
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
            $args = array_merge($args, ['hash' => $responseData['bookingHash'], 'bookingId' => $responseData['bookingId']]);
            return $response->withRedirect($this->container->get('router')->pathFor('thank', $args));
        }else{
            if($responseData['errorcode'] == 2){
                return $response->withRedirect($this->container->get('router')->pathFor('error_occupied', $args));
            }else{
                return $response->withRedirect($this->container->get('router')->pathFor('error_technical', $args));
            }
        }
    }

    public function thank($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/thank.html.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }
}