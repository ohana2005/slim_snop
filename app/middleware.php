<?php
/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/23/18
 * Time: 20:57
 */

$app->add(function ($request, $response, $next) {

    $response = $next($request, $response);

    return $response;
});