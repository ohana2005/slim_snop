<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/28/18
 * Time: 14:45
 */
class ErrorController extends BaseController
{
    public function technical($request, $response, $args){
        $this->container['service']->init($args);
        return $this->view('error/technical.html.php');
    }

    public function occupied($request, $response, $args){
        $this->container['service']->init($args);
        return $this->view('error/occupied.html.php');
    }
}