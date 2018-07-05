<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/25/18
 * Time: 18:24
 */
class HtmlService extends BaseService
{
    protected $widgetMode = false;

    public function setWidgetMode($mode)
    {
        $this->widgetMode = $mode;
    }

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
        $js = [
          '/jquery/jquery-3.3.1.slim.min.js',
            '/bootstrap-4.1.1/js/bootstrap.min.js',
            '/gijgo-combined-1.9.6/js/gijgo.min.js',
            '/snop/js/snop.js'
        ];
        if($this->widgetMode){
            $js[] = '/snop/js/widget_utils.js';
            $js[] = '/snop/js/widget.js';
        }
        return $js;
    }

    public function getWidgetJs()
    {
        $this->widgetMode = true;
        return $this->getJsCompiledString(false);
    }

    public function getJsCompiledString($wrap = true){
        $str = "";
        foreach($this->getBaseJs() as $path){
            $str .= file_get_contents(PUBLIC_DIR . $path);
            $str .= "\n";
        }
        return $wrap ? $this->wrapJs($str) : $str;
    }

    public function wrapJs($js){
        $wrapped = "(function(version){\n";
        $wrapped .= $js;
        $wrapped .= "\n";
        $wrapped .= "})('Version 0.8.1');";
        return $wrapped;
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

    public function getCssCompiledString()
    {
        $strcss = '';
        foreach($this->getBaseCss() as $path) {
            $strcss .= $this->getCssString($path);
            $strcss .= "\n";
        }
        $skin = $this->container['hotel']->getSkin();
        $skinpath = "/skin/$skin/skin.css";
        $strcss .= file_get_contents(PUBLIC_DIR . $skinpath);
        $strcss .= "\n";
        $strcss .= $this->container['hotel']->getConfig('css', '');
        return $strcss;
    }
}