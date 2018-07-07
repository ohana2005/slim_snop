<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 17:12
 */
class BaseController
{
    protected $container;
    protected $_view;
    protected $_is_widget = false;
    protected $_base = 'frame/base.html.php';

    public function __construct( \Slim\Container  $container) {
        $this->container = $container;
        $this->_view = new \Slim\Views\PhpRenderer(APP_DIR . '/view/');
        if(!empty($_GET['mode']) && $_GET['mode'] == 'widget'){
            $this->_is_widget = true;
            $this->_base = 'frame/widget.html.php';
        }
    }

    protected function view($template, $params = []){
        $skin = $this->container['hotel']->getSkin();
        $content = $this->_view->fetch($skin . '/' . $template, $params);
        return $this->_view->render($this->container['response'], $skin . '/' . $this->_base, array_merge(['content' => $content], $params));
    }

    protected function viewRaw($template, $params = []){
        return $this->_view->fetch( $template, $params);
    }

    protected function isWidget(){
        return $this->_is_widget;
    }
}