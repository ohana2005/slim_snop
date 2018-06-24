<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 18:13
 */
class HotelService extends BaseService
{

    protected $_config = null;
    protected $_hotel = null;
    protected $_hotelid = null;
    public function init($name){
        try {
            $stmt = $this->db()->query("SELECT * FROM `hotel` WHERE `slug`='{$name}' LIMIT 1");
            $row = $stmt->fetch();
            $this->_hotel = $row;
            $this->_hotelid = $row['id'];
            $this->readConfig();
        }catch(Exception $e){
            throw new Exception("Undefined hotel $name");
        }
    }

    public function getConfig($name, $default = ''){
        if(!$this->_config){
            $this->readConfig();
        }
        return isset($this->_config[$name]) ? $this->_config[$name] : $default;
    }

    public function getHotel(){
        return $this->_hotel;
    }

    protected function readConfig(){
        $arr = array();
        $stmt = $this->db()->query("SELECT * FROM `hotel_config` WHERE  `hotel_id` = {$this->_hotelid}");
        while ($row = $stmt->fetch()) {
            switch ($row['datatype']) {
                case 'enum':
                    list(, $arr[$row['keyname']]) = explode("::", $row['value']);
                    break;
                default:
                    $arr[$row['keyname']] = $row['value'];
                    break;
            }
        }
        $this->_config = $arr;
    }

    public function findRooms() {

    }
}