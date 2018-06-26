<?php


$app->get('/search/{hotel}/{lang}', \HotelController::class . ':search')->setName('search');
$app->get('/rooms/{hotel}/{lang}', \HotelController::class . ':rooms')->setName('rooms');
$app->get('/checkout/{hotel}/{lang}', \HotelController::class . ':checkout');
$app->post('/checkout/{hotel}/{lang}', \HotelController::class . ':checkout');
$app->get('/thank/{hotel}/{lang}', \HotelController::class . ':thank');
$app->get('/', \HomeController::class . ':home');