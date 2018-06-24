<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 21:38
 */
class ServiceService extends BaseService
{
    public function init($args){
        $this->container['hotel']->init($args['hotel']);
        $this->container['i18n']->init($args['lang']);
    }
}