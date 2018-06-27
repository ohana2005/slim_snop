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

    public function __construct($container)
    {
        parent::__construct($container);

        $this->_read_session();
    }
    public function setRooms($Rooms){
        $this->_data['rooms'] = $Rooms;
    }

    public function addToOrder($key)
    {
        $this->_data['orderkey'] = $key;
        if(!empty($this->_data['rooms'][$key])) {
            $item = $this->_data['rooms'][$key];
            $this->_data['order'] = $item;
        }
    }

    public function getOrder(){
        return $this->_data['order'];
    }

    public function __destruct() {
        $this->_session_persist();
    }

    public function create($data){
        $order = $this->getOrder();
        $search = $this->container['search']->getData();
        $orderData = [
            'room_category_id' => $order['room']['id'],
            'package_id' => $order['package']['id'],
            'price' => $order['price']['price']
        ];
        $responseData = $this->container['api']->saveBooking([
           'order' => $orderData,
            'search' => $search,
            'guest' => $data
        ]);
        print_r($responseData);die;

// Check for errors

    }

}