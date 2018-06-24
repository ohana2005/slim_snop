<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 18:00
 */
class BaseService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function db(){
        return $this->container['db'];
    }
}