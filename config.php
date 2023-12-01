<?php

use Jonashcr\Blog\Infra\ConnectDB;

session_start();

define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000');
define('BASE_URL_ADMIN', 'http://localhost:8000/admin');

$connect  = new ConnectDB();
$db = $connect->getConnection();