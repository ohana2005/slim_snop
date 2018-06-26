<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/25/18
 * Time: 17:20
 */
class SearchService extends BaseService
{
    public function __construct($container)
    {
        parent::__construct($container);

        $this->_read_session();
    }

    public function init($args){
        foreach($args as $key => $value){
            $this->_setValue($key, $value);
        }
    }

    public function validate(){
        return true;
    }

    public function getData(){
        return $this->_data;
    }

    public function getDataValues(){
        $_defaults = [
            'arr' => date('Y-m-d'),
            'dep' => date('Y-m-d', strtotime(time() + 60 * 60 * 24)),
            'a' => 1,
            'c' => 0,
            'ca' => []
        ];
        $values = [];
        $map = ['arr' => 'dateArrival', 'dep' => 'dateDeparture', 'c' => 'childrenCount', 'a' => 'adultsCount', 'ca' => 'childrenAge', 'n' => 'nights'];
        foreach($map as $key => $label){
            $value = !empty($this->_data[$key]) ? $this->_data[$key] : $_defaults[$key];
            switch ($key) {
                case 'arr':
                case 'dep':
                    $value = date('d.m.Y', strtotime($value));
                    break;
            }

            $values[$label] = $value;

        }
        return $values;
    }

    public function getPersonsCount(){
        return $this->_data['a'] + $this->_data['c'];
    }

    public function getAdultsCount(){
        return $this->_data['a'];
    }

    public function getChildrenCount(){
        return $this->_data['c'];
    }

    public function getDateArrival(){
        return $this->_data['arr'];
    }

    public function getDateDeparture(){
        return $this->_data['dep'];
    }


    protected function _session_persist() {
        $_SESSION['snop_data'] = $this->_data;
    }
    protected function _read_session(){
        $this->_data = !empty($_SESSION['snop_data']) ? $_SESSION['snop_data'] : [];
    }


    public function __destruct() {
        $this->_session_persist();
    }

    protected function _setValue($key, $value){
        $calcNights = false;
        switch ($key){
            case 'dep':
            case 'arr':
                $value = date('Y-m-d', strtotime($value));
                $calcNights = true;
                break;
            case 'ca':
                $value = array_filter($value);
                break;
        }
        $this->_data[$key] = $value;

        if($calcNights){
            $this->calculateNights();
        }
    }

    public function calculateNights() {
        $nights = ceil((strtotime($this->_data['dep']) - strtotime($this->_data['arr'])) / 86400);
        $this->_data['n'] = $nights;
    }

    public function getDatesRange()
    {
        return $this->createDateRange($this->_data['arr'], $this->_data['dep']);
    }

    private function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);

        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }

    private function _from_camel_case($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}