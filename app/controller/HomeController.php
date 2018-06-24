<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 15:51
 */
class HomeController extends BaseController
{


    public function home($request, $response, $args) {

        return $this->view('home.php');
    }
}