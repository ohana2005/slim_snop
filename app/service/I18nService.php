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
    protected $saveToCache = false;
    public function init($lang){
        $this->_lang = $lang;
        $this->load();
    }

    public function load(){
        $this->_data = [];
        if(file_exists($this->getCacheFilePath())){
            $this->_data = unserialize(file_get_contents($this->getCacheFilePath()));
        }else{
            $this->loadFromDb();
        }
    }

    public function loadFromDb(){
        $query = "SELECT tb.name, tbt.text FROM text_block tb 
JOIN text_block_translation tbt ON tb.id = tbt.id AND tbt.lang='{$this->_lang}'
WHERE tb.application = 'frontend'";
        $stmt = $this->db()->query($query);
        while($row = $stmt->fetch()){
            if(!empty($row['text'])){
                $this->_data[$row['name']] = $row['text'];
            }
        }
        $this->saveToCache = true;

    }

    public function translate($key, $pairs = array(), $marker = false){
        if(!isset($this->_data[$key])){
            $this->_data[$key] = false;
            $this->saveToCache = true;
        }
        $value = !empty($this->_data[$key]) ? $this->_data[$key] : $key;
        return strtr($value, $pairs);
    }

    public function getLang(){
        return $this->_lang;
    }

    public function __destruct()
    {
        if($this->saveToCache) {
            $this->_dumpData();
        }
    }

    protected function _dumpData(){
        file_put_contents($this->getCacheFilePath(), serialize($this->_data));
    }

    protected function getCacheFilePath(){
        return CACHE_DIR . '/' . $this->_lang . '.lang';
    }
}