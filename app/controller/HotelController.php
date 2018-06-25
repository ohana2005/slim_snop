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
        return $this->view('hotel/rooms.html.php', [
            'hotel' => $this->container['hotel']->getHotel(),
            'search' => $this->container['search']->getDataValues()
        ]);
    }

    public function checkout($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/checkout.html.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }

    public function thank($request, $response, $args)
    {
        $this->container['service']->init($args);
        return $this->view('hotel/thank.html.php', [
            'hotel' => $this->container['hotel']->getHotel()
        ]);
    }
}