<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Framework\HTTP\Request\Request;
use Framework\Routing\Router;

// invalidate cache

$router = new Router(new Request());
try {
    $router->addRoute();
} catch (Exception $e) {
    echo $e->getMessage();
 }