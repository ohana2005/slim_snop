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
    protected $_hotelId = null;
    protected $_hotelSlug = null;
    protected $_hotelApihash = null;
    public function init($name){
        try {
            $stmt = $this->db()->query("SELECT * FROM `hotel` WHERE `slug`='{$name}' LIMIT 1");
            $row = $stmt->fetch();
            $this->_hotel = $row;
            $this->_hotelId = $row['id'];
            $this->_hotelApihash = $row['apihash'];
            $this->_hotelSlug = $name;
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

    public function getSkin() {
        return $this->getConfig('skin', 'default');
    }

    public function getHotel(){
        return $this->_hotel;
    }

    public function getHotelId(){
        return $this->_hotelId;
    }

    public function getHotelSlug(){
        return $this->_hotelSlug;
    }
    public function getHotelApihash(){
        return $this->_hotelApihash;
    }

    protected function readConfig(){
        $arr = array();
        $stmt = $this->db()->query("SELECT * FROM `hotel_config` WHERE  `hotel_id` = {$this->_hotelId}");
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
        $availableCategories = $this->getAvailableCategories();
        $availablePackages = $this->getAvailablePackages();

        $priceItems = [];
        foreach($availableCategories as $cat){
            foreach($availablePackages as $package) {
                $price = $this->getRoomCategoryPrice($cat, $package);
                if(!empty($price)){
                    $priceItems[$cat['id'] . '_' . $package['id']] = [
                        'room' => $cat,
                        'package' => $package,
                        'price' => $price
                    ];
                }
            }
        }


        return $priceItems;

    }

    public function getAvailableCategories() {
        $adultsCount = $this->container['search']->getAdultsCount();
        $childrenCount = $this->container['search']->getChildrenCount();
        $personsCount = $this->container['search']->getPersonsCount();
        $dateArrival = $this->container['search']->getDateArrival();
        $dateDeparture = $this->container['search']->getDateDeparture();
        $fitting_rooms = [];
        $query = "
            SELECT r.*, rc.name, rc.description FROM `room` r
            JOIN `room_category` rc ON r.room_category_id = rc.id
            WHERE $personsCount BETWEEN rc.min_persons AND rc.max_persons
            AND rc.hotel_id = {$this->_hotelId}
        ";
        $stmt = $this->db()->query($query);
        while($row = $stmt->fetch()){
            $fitting_rooms[] = $row;
        }


        foreach($fitting_rooms as &$room){

            $query = "SELECT ro.* FROM `room_occupancy` ro 
            LEFT JOIN `room_occupancy_entity` roe ON ro.room_occupancy_entity_id = roe.id
            WHERE ro.room_id = {$room['id']} 
            AND ro.date BETWEEN '$dateArrival' AND '$dateDeparture'
            ";

            $stmt = $this->db()->query($query);
            while($row = $stmt->fetch()){
                if($row['is_occupied'] || $row['is_closed']){
                    $room['occupied'] = true;
                }else{
                    if($row['is_arrival'] && $row['date'] != $dateDeparture){
                        $room['occupied'] = true;
                    }
                    if($row['is_departure'] && $row['date'] != $dateArrival){
                        $room['occupied'] = true;
                    }
                }
            }

        }

        $rooms = [];

        foreach($fitting_rooms as $f_room){

            if(empty($f_room['occupied'])){
                if(empty($rooms[$f_room['room_category_id']])){
                    $rooms[$f_room['room_category_id']] = [
                        'name' => $f_room['name'],
                        'description' => $f_room['description'],
                        'id' => $f_room['room_category_id'],
                        'rooms' => [[$f_room['id'], $f_room['number']]],
                        'count' => 1
                    ];
                }else{
                    $rooms[$f_room['room_category_id']]['count']++;
                    $rooms[$f_room['room_category_id']]['rooms'][] = [$f_room['id'], $f_room['number']];
                }
            }
        }


        return $rooms;



    }


    public function getAvailablePackages(){
        $adultsCount = $this->container['search']->getAdultsCount();
        $childrenCount = $this->container['search']->getChildrenCount();
        $nights = $this->container['search']->getNights();
        $packages = [];
        $query = "
            SELECT pi.*, p.name package_name, p.description package_description, p.id package_id FROM `package_item` pi
            JOIN `package_item2_package` pi2p ON pi2p.package_item_id = pi.id
            JOIN `package` p ON p.id = pi2p.package_id
             WHERE pi.hotel_id = {$this->_hotelId}
             AND $adultsCount BETWEEN p.min_adults AND p.max_adults
             AND $childrenCount BETWEEN p.min_children AND p.max_children
             AND $nights BETWEEN p.min_stay AND p.max_stay
             
             ";
        $stmt = $this->db()->query($query);
        while($row = $stmt->fetch()){
            if(empty($packages[$row['package_id']])){
                $packages[$row['package_id']] = [
                    'name' => $row['package_name'],
                    'description' => $row['package_description'],
                    'id' => $row['package_id'],
                    'items' => []
                ];
            }
            unset($row['package_name'], $row['package_description']);
            $packages[$row['package_id']]['items'][$row['id']] = $row;
        }
        return $packages;

    }

    public function getRoomCategoryPrice($category, $package){
        $priceAll = [];
        $adultsCount = $this->container['search']->getAdultsCount();
        $childrenCount = $this->container['search']->getChildrenCount();
        $personsCount = $this->container['search']->getPersonsCount();
        $dateArrival = $this->container['search']->getDateArrival();
        $dateDeparture = $this->container['search']->getDateDeparture();
        $datesRange = $this->container['search']->getDatesRange();


        $price_cat = $this->getRangeKeys($datesRange);
        $query_category = "
            SELECT * FROM `price_item` pi WHERE 
            pi.`room_category_id`={$category['id']}
             AND pi.date BETWEEN '{$dateArrival}' AND '{$dateDeparture}'
              order by pi.date
        ";
        $stmt = $this->db()->query($query_category);
        while($row = $stmt->fetch()){
            foreach($price_cat as $datekey => $val){
                if($row['date'] == $datekey){
                    if($row['price']) {
                        $price_cat[$datekey] = $row['price'];
                    }
                }
            }
        }

        if(!$this->validatePriceRange($price_cat)){
            $this->invalidRoomPriceAlert($category['id']);
            return $priceAll;
        }

        $price_package = [];
        foreach($package['items'] as $package_item){
            $modifier = 1;
            if ($package_item['per_person'] == 'adult') {
                $modifier = $adultsCount;
            } elseif ($package_item['per_person'] == 'child') {
                $modifier = $childrenCount;
            } elseif($package_item['per_person'] == 'person'){
                $modifier = $childrenCount + $adultsCount;
            }
            if($package_item['per_period'] == 'day') {
                if ($modifier) {
                    $price_package[$package_item['id']] = $this->getRangeKeys($datesRange);
                    $query = "
                    SELECT * FROM `price_item` pi WHERE 
                    pi.`package_item_id`={$package_item['id']}
                     AND pi.date BETWEEN '{$dateArrival}' AND '{$dateDeparture}'
                      order by pi.date
                ";
                    $stmt = $this->db()->query($query);
                    while ($row = $stmt->fetch()) {
                        foreach ($price_package[$package_item['id']] as $datekey => $val) {
                            if ($row['date'] == $datekey) {
                                if ($row['price']) {
                                    $price_package[$package_item['id']][$datekey] = $row['price'] * $modifier;
                                }
                            }
                        }
                    }
                    if (!$this->validatePriceRange($price_package[$package_item['id']])) {
                        $this->invalidPackagePriceAlert($package['id'], $package_item['id']);
                        return $priceAll;
                    }
                }
            }elseif($package_item['per_period'] == 'booking'){
                $query = "
                    SELECT * FROM `price_item` pi WHERE 
                    pi.`package_item_id`={$package_item['id']}
                     AND pi.date = '{$dateArrival}'
                      LIMIT 1
                ";
                $stmt = $this->db()->query($query);
                if($row = $stmt->fetch()){
                    $price_package[$package_item['id']] = [$dateArrival => $row['price'] * $modifier];
                }else{
                    return $priceAll;
                }

            }
        }

        $totalPrice = 0;
        foreach($price_cat as $date => $price){
            $dateTotal = 0;
            $priceAll[$date] = [
                'room' => $price,
                'items' => []
            ];
            $totalPrice += $price;
            $dateTotal += $price;
            foreach($price_package as $p_item_id => $pi_prices){
                $priceAll[$date]['items'][$p_item_id] = $pi_prices[$date];
                $totalPrice += $pi_prices[$date];
                $dateTotal += $pi_prices[$date];
            }
            $priceAll[$date]['total'] = $dateTotal;
        }
        $priceAll['price'] = $totalPrice;

        return $priceAll;



    }

    private function getRangeKeys($range){
        $arr = [];
        foreach($range as $date){
            $arr[$date] = false;
        }
        return $arr;
    }

    private function validatePriceRange($price_range){
        foreach($price_range as $date => $price){
            if($price === false){
                return false;
            }
        }
        return true;
    }

    protected function invalidRoomPriceAlert($room_id){

    }

    protected function invalidPackagePriceAlert($package_id, $package_item_id){

    }

}