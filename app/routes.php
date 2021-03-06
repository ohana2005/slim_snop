<?php


$app->get('/search/{hotel}/{lang}', \HotelController::class . ':search')->setName('search');
$app->get('/rooms/{hotel}/{lang}', \HotelController::class . ':rooms')->setName('rooms');
$app->get('/roombook/{hotel}/{lang}/{key}', \HotelController::class . ':roombook')->setName('roombook');
$app->get('/checkout/{hotel}/{lang}', \HotelController::class . ':checkout')->setName('checkout');
$app->post('/checkout/{hotel}/{lang}', \HotelController::class . ':checkoutPost');
$app->get('/pay-booking/{hotel}/{lang}', \HotelController::class . ':payBooking')->setName('pay_booking');
$app->get('/error/occupied/{hotel}/{lang}', \ErrorController::class . ':occupied')->setName('error_occupied');
$app->get('/error/technical/{hotel}/{lang}', \ErrorController::class . ':technical')->setName('error_technical');
$app->get('/thank/{hotel}/{lang}', \HotelController::class . ':thank')->setName('thank');
$app->get('/widget/{hotel}/{lang}/load', \WidgetController::class . ':load')->setName('widget_load');
$app->get('/widget/{hotel}/css', \WidgetController::class . ':css')->setName('widget_css');
$app->get('/payment/{hotel}/{lang}/success', \PaymentController::class . ':success')->setName('payment_success');
$app->get('/payment/{hotel}/{lang}/cancel', \PaymentController::class . ':cancel')->setName('payment_cancel');
$app->get('/payment/{hotel}/{lang}/failure', \PaymentController::class . ':failure')->setName('payment_failure');
$app->get('/', \HomeController::class . ':home');