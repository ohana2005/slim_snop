<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 21:29
 */
class I18nService extends BaseService
{
    protected $_lang = DEFAULT_LANG;
    protected $_data = null;
    public function init($lang){
        $this->_lang = $lang;
        $this->load();
    }

    public function load(){

    }

    public function translate($key, $pairs = array(), $marker = false){
        return isset($this->_data[$key]) ? $this->_data[$key] : $key;
    }

    public function getLang(){
        return $this->_lang;
    }
}