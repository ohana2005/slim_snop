<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 7/5/18
 * Time: 14:24
 */
class WidgetController extends BaseController
{
    public function load($request, $response, $args)
    {
        $this->container['service']->init($args);

        $js = $this->container['html']->getWidgetJs();
        $params = [];
        $js_routes = $this->viewRaw('default/widget/routes.js.php', array_merge($params, $args));
        $js_load = $this->viewRaw('default/widget/load.js.php', array_merge($params, $args));

        $js = $js . "\n" . $js_routes . "\n" . $js_load;

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'text/javascript')
            ->write($this->container['html']->wrapJs($js));
    }

    public function css($request, $response, $args)
    {
        $this->container['service']->init($args);

        $css = $this->container['html']->getCssCompiledString();

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'text/css')
            ->write($css);
    }
}