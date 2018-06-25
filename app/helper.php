<?php



    function cnfg($name, $default = ''){
        global $container;
        return $container['hotel']->getConfig($name, $default);

    }


    function __($value, $pairs = [], $marker = false){
        global $container;
        return $container['i18n']->translate($value, $pairs, $marker);
    }


    function url($name, $params = []){
        global $container;
        return $container->get('router')->pathFor($name, $params);
    }

    function snop_url($name, $params = []){
        global $container;
        $lang = $container['i18n']->getLang();
        $slug = $container['hotel']->getHotelSlug();
        return url($name, array_merge(['hotel' => $slug, 'lang' => $lang], $params));
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