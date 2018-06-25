<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/25/18
 * Time: 18:24
 */
class HtmlService extends BaseService
{
    public function getBaseCss()
    {
        return [
           '/bootstrap-4.1.1/css/bootstrap.min.css',
            '/gijgo-combined-1.9.6/css/gijgo.min.css',
            '/snop/css/snop.css'
        ];
    }

    public function getBaseJs(){
        return [
          '//code.jquery.com/jquery-3.3.1.slim.min.js',
            '/bootstrap-4.1.1/js/bootstrap.min.js',
            '/gijgo-combined-1.9.6/js/gijgo.min.js',
            '/snop/js/snop.js'
        ];
    }
}