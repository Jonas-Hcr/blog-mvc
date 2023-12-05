<?php

namespace  Jonashcr\Infra;

class ConnectDB
{
    private static $pdo = null;

    public function getConnection(): \PDO
    {
        if (is_null(self::$pdo)) {
            self::$pdo = new \PDO('mysql:host=blog-db-1;dbname=blog_db', 'blog_user','123456')or print(mysql_error());
        }

        return self::$pdo;
    }
}
