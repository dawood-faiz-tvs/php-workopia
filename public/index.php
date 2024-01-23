<?php
require('../helpers.php');
// loadView("home");

$routes = [
    '/' => 'controllers/home.php',
    '/listings' => 'controllers/listings/index.php',
    '/listings/create' => 'controllers/listings/create.php',
    '404' => 'controllers/error/404.php',
];

if (array_key_exists($_SERVER['REQUEST_URI'], $routes)) {
    require(basePath($routes[$_SERVER['REQUEST_URI']]));
} else {
    require(basePath($routes['404']));
}
