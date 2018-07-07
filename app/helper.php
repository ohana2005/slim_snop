<?php



    function cnfg($name, $default = ''){
        global $container;
        return $container['hotel']->getConfig($name, $default);

    }


    function __($value, $pairs = [], $marker = false){
        global $container;
        return $container['i18n']->translate($value, $pairs, $marker);
    }

    function _date($date){
        return date('d.m.Y', strtotime($date));
    }


    function url($name, $params = []){
        global $container;
        return $container->get('router')->pathFor($name, $params);
    }

    function price($value, $currency = true){
        return number_format($value, 2, ',', '.') . ($currency ? ' ' . cnfg('currency') : '');
    }

    function snop_url($name, $params = []){
        global $container;
        $lang = $container['i18n']->getLang();
        $slug = $container['hotel']->getHotelSlug();
        return host('') . url($name, array_merge(['hotel' => $slug, 'lang' => $lang], $params));
    }


    function form_children($value = false){
        $from = 0;
        $to = 4;
        $options = "";
        for($i = $from; $i <= $to; $i++){
            $selected = $i == $value ? 'selected' : '';
            $options .= "<option value='{$i}' $selected>{$i}</option>";
        }
        return $options;
    }

    function form_adults($value = false){
        $from = 1;
        $to = 4;
        $options = "";
        for($i = $from; $i <= $to; $i++){
            $selected = $i == $value ? 'selected' : '';
            $options .= "<option value='{$i}' $selected>{$i}</option>";
        }
        return $options;
    }

    function include_css(){
        global $container;
        $filename = $container['html']->makeFilenameCss();
        $filepath = PUBLIC_CACHE_DIR . '/css/' . $filename;
        if(!file_exists($filepath)){
            $strcss = $container['html']->getCssCompiledString();
            file_put_contents($filepath, $strcss);
        }
        echo "<link rel='stylesheet' type='text/css' href='/cache/css/$filename' >";
    }
    function include_js(){
        global $container;
        $filename = $container['html']->makeFilenameJs();
        $filepath = PUBLIC_CACHE_DIR . '/js/' . $filename;
        if(!file_exists($filepath)){
            $str = $container['html']->getJsCompiledString();
            file_put_contents($filepath, $str);
        }

        echo "<script type='text/javascript' src='/cache/js/$filename'></script>";
    }

    function gallery_path($image, $type = 'small')
    {
        return IMAGE_HOST . '/room_gallery/' . $image['image'] . '.' . $type;
    }

    function host($lastSlash = '/'){
        return '//' . $_SERVER['HTTP_HOST'] . $lastSlash;
    }