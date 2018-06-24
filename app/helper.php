<?php



    function cnfg($name, $default = ''){
        global $container;
        return $container['hotel']->getConfig($name, $default);

    }