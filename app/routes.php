<?php


$app->get('/search/{hotel}/{lang}', \HotelController::class . ':search')->setName('search');
$app->get('/rooms/{hotel}/{lang}', \HotelController::class . ':rooms')->setName('rooms');
$app->get('/roombook/{hotel}/{lang}/{key}', \HotelController::class . ':roombook')->setName('roombook');
$app->get('/checkout/{hotel}/{lang}', \HotelController::class . ':checkout')->setName('checkout');
$app->post('/checkout/{hotel}/{lang}', \HotelController::class . ':checkoutPost');
$app->get('/error/occupied/{hotel}/{lang}', \ErrorController::class . ':occupied')->setName('error_occupied');
$app->get('/error/technical/{hotel}/{lang}', \ErrorController::class . ':technical')->setName('error_technical');
$app->get('/thank/{hotel}/{lang}/{bookingId}/{hash}', \HotelController::class . ':thank')->setName('thank');
$app->get('/', \HomeController::class . ':home');