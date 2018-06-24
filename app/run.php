<?php
    define('ROOT_DIR', dirname(__FILE__) . '/..');
    define('APP_DIR', ROOT_DIR . '/app');
    define('DEFAULT_LANG', 'ru');

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    $config['displayErrorDetails'] = true;
    $config['db']['host']   = '127.0.0.1';
    $config['db']['user']   = 'root';
    $config['db']['pass']   = '';
    $config['db']['dbname'] = 'snop';

    $app = new \Slim\App(['settings' => $config]);

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
    $container['hotel'] = new HotelService($container);
    $container['i18n'] = new I18nService($container);
    $container['service'] = new ServiceService($container);

    require_once APP_DIR . '/routes.php';
    require_once APP_DIR . '/helper.php';
    require_once APP_DIR . '/middleware.php';

    $app->run();