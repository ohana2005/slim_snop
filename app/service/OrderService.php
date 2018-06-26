<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 17:59
 */
class OrderService extends BaseService implements SessionStorageInterface
{

    use SessionStorageTrait;
    protected $_data = [];

    protected $_session_name = 'snop_order_data';


    public function setRooms($Rooms){
        $this->_data['rooms'] = $Rooms;
    }

    public function addToOrder($key)
    {
        $this->_data['orderkey'] = $key;
        if(!empty($this->_data['rooms'][$key])) {
            $this->_data['order'] = $this->_data['rooms'][$key];
        }
    }

    public function getOrder(){
        return $this->_data['order'];
    }

}