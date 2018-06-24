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
        return $this->view('hotel/search.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }

    public function rooms($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/rooms.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }

    public function checkout($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/checkout.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }

    public function thank($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/thank.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }
}