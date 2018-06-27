<?php


$app->get('/search/{hotel}/{lang}', \HotelController::class . ':search')->setName('search');
$app->get('/rooms/{hotel}/{lang}', \HotelController::class . ':rooms')->setName('rooms');
$app->get('/roombook/{hotel}/{lang}/{key}', \HotelController::class . ':roombook')->setName('roombook');
$app->get('/checkout/{hotel}/{lang}', \HotelController::class . ':checkout')->setName('checkout');
$app->post('/checkout/{hotel}/{lang}', \HotelController::class . ':checkoutPost');
$app->get('/thank/{hotel}/{lang}', \HotelController::class . ':thank');
$app->get('/', \HomeController::class . ':home');