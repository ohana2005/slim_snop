<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/26/18
 * Time: 23:07
 */
trait SessionStorageTrait
{

    public function _session_persist() {
        $_SESSION[$this->_session_name] = $this->_data;
    }
    public function _read_session(){
        $this->_data = !empty($_SESSION[$this->_session_name]) ? $_SESSION[$this->_session_name] : [];
    }

    public function getData(){
        return $this->_data;
    }

}