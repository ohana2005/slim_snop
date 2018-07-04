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
            '/fontawesome-5.1.0/css/all.css',
            '/snop/css/snop.css'
        ];
    }

    public function getBaseJs(){
        return [
          '/jquery/jquery-3.3.1.slim.min.js',
            '/bootstrap-4.1.1/js/bootstrap.min.js',
            '/gijgo-combined-1.9.6/js/gijgo.min.js',
            '/snop/js/snop.js'
        ];
    }

    public function getCssString($path){
        $info = pathinfo($path);
        $dirname = explode('/', $info['dirname']);
        array_pop($dirname);
        $dirname = join('/', $dirname);
        $path = PUBLIC_DIR . $path;
        $strCss = file_get_contents($path);
        $strCss = str_replace('url(../', 'url(' . $dirname . '/', $strCss);
        return $strCss;
    }
}