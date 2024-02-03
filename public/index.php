<?php
session_start();
require('../helpers.php');
require(__DIR__ . '/../vendor/autoload.php');

use Framework\Router;

$router = new Router();

require(basePath('routes.php'));

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->route($uri);
