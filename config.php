<?php

use  Jonashcr\Infra\ConnectDB;

session_start();

define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000');
define('BASE_URL_ADMIN', 'http://localhost:8000/admin');
define('ADMIN_VIEW', ROOT_PATH . '/src/Admin/view');
define('BLOG_VIEW', ROOT_PATH . '/src/Blog/view');
/** ACESSO AO BANCO DE DADOS */
define('DB_HOST', 'blog-db-1');
define('DB_USER', 'blog_user');
define('DB_PASS', '123456');
define('DB_NAME', 'blog_db');

$connect  = new ConnectDB();
$db = $connect->getConnection();