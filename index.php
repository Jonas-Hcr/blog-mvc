<?php
require 'vendor/autoload.php';
require 'config.php';

use Jonashcr\Admin\Users\User;
use  Jonashcr\Infra\Routes\Router;

if (!empty($_SESSION['user_id'])) {
    new User(
        $_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['role']
    );
}

$router = new Router();
$router->run($_SERVER['REQUEST_URI']);