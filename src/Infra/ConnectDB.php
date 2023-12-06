<?php

/**
 * Arquivo responsável por realizar a conexão com o banco e disponibilizar para a aplicação
 */

namespace  Jonashcr\Infra;

class ConnectDB
{
    private static $pdo = null;

    public function getConnection(): \PDO
    {
        if (is_null(self::$pdo)) {
            self::$pdo = new \PDO(sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME), DB_USER, DB_PASS)or print(mysql_error());
        }

        return self::$pdo;
    }
}
