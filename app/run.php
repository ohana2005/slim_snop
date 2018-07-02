<?php

    session_start();

    define('ROOT_DIR', dirname(__FILE__) . '/..');
    define('APP_DIR', ROOT_DIR . '/app');
    define('CONFIG_DIR', APP_DIR . '/config');
    define('DEFAULT_LANG', 'ru');

    require_once CONFIG_DIR . '/inc.php';
    require_once CONFIG_DIR . '/db.php';
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;



    $app = new \Slim\App(['settings' => $_config]);

    $container = $app->getContainer();
    $container['db'] = function ($c) {
        $db = $c['settings']['db'];
        $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
            $db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    };

    $container['order'] = new OrderService($container);
    $container['search'] = new SearchService($container);
    $container['hotel'] = new HotelService($container);
    $container['i18n'] = new I18nService($container);
    $container['service'] = new ServiceService($container);
    $container['html'] = new HtmlService($container);
    $container['api'] = new ApiService($container);

    require_once APP_DIR . '/routes.php';
    require_once APP_DIR . '/helper.php';
    require_once APP_DIR . '/middleware.php';

    $app->run();