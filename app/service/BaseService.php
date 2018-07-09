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

    protected function generateUrl($name, $full = false)
    {
        $lang = $this->container['i18n']->getLang();
        $slug = $this->container['hotel']->getHotelSlug();
        return ($full ? '//' . $_SERVER['HTTP_HOST'] : '') . $this->container->get('router')->pathFor($name, ['hotel' => $slug, 'lang' => $lang]);
    }
}