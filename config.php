<?php

use  Jonashcr\Infra\ConnectDB;

session_start();

define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000');
define('BASE_URL_ADMIN', 'http://localhost:8000/admin');
define('ADMIN_VIEW', ROOT_PATH . '/src/Admin/view');
define('BLOG_VIEW', ROOT_PATH . '/src/Blog/view');

$connect  = new ConnectDB();
$db = $connect->getConnection();