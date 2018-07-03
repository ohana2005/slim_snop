<?php


$_config = [];

define('ROOT_DIR', dirname(__FILE__) . '/..');
define('CACHE_DIR', ROOT_DIR . '/cache');


require_once dirname(__FILE__) . '/../app/config/db.php';
$db = $_config['db'];
$pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
    $db['user'], $db['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


