<?php
require 'vendor/autoload.php';
require 'config.php';

use  Jonashcr\Infra\Routes\Router;

$router = new Router();
$router->run($_SERVER['REQUEST_URI']);