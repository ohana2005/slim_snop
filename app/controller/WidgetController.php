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

        $file_path = PUBLIC_CACHE_DIR . '/js/' . $this->container['html']->makeFilenameJs(true);
        if(file_exists($file_path)){
            $js = file_get_contents($file_path);
        }else {
            $js = $this->container['html']->getWidgetJs();
            $params = [];
            $js_routes = $this->viewRaw('default/widget/routes.js.php', array_merge($params, $args));
            $js_load = $this->viewRaw('default/widget/load.js.php', array_merge($params, $args));

            $js = $js . "\n" . $js_routes . "\n" . $js_load;
            $js = $this->container['html']->wrapJs($js);
            file_put_contents($file_path, $js);
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'text/javascript')
            ->write($js);
    }

    public function css($request, $response, $args)
    {
        $this->container['service']->init($args);

        $file_path = PUBLIC_CACHE_DIR . '/css/' . $this->container['html']->makeFilenameCss(true);
        if(file_exists($file_path)){
            $css = file_get_contents($file_path);
        }else {
            $css = $this->container['html']->getCssCompiledString();
            file_put_contents($file_path, $css);
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'text/css')
            ->write($css);
    }
}