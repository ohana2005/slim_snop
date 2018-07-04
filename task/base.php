<?php


$_config = [];

define('ROOT_DIR', dirname(__FILE__) . '/..');
define('CACHE_DIR', ROOT_DIR . '/cache');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('PUBLIC_CACHE_DIR', PUBLIC_DIR . '/cache');

if(file_exists(dirname(__FILE__) . '/../app/config/env.php')) {
    require_once dirname(__FILE__) . '/../app/config/env.php';
}else{
    require_once dirname(__FILE__) . '/../app/config/env.dist.php';
}
$db = $_config['db'];
$pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
    $db['user'], $db['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


