<?php

/**
 * Responsável por realizar o setup do banco de dados, 
 * criando as tabelas necessárias para rodar o projeto.
 *  E mantém o versionamento do banco.
 */

namespace Jonashcr\Setup;

class Setup
{
    public function run()
    {
        global $db;

        try {
            $sqlUser = "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            `username` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `role` enum('Visitor','Admin') DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";

            $db->exec($sqlUser);

            $sqlPosts = "CREATE TABLE IF NOT EXISTS `posts` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) DEFAULT NULL,
            `title` varchar(255) NOT NULL,
            `slug` varchar(255) NOT NULL UNIQUE,
            `image` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `status` tinyint(1) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ";

            $db->exec($sqlPosts);

            echo "<h1>Tabelas Criadas com Sucesso!</h1>";

            /* SEED - Usuário Admin */
            $username = 'admin';
            $email = 'admin@jonashcr.com.br';
            $password = password_hash('@dmin123', PASSWORD_BCRYPT);
            $role = 'Admin';

            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);

            $stmt->execute();

            echo "<h2>Seed de User Criada com Sucesso!</h2>";
        } catch (\Throwable $th) {
            echo sprintf("<h1>Erro ao criar tabelas: %s </h1>", $th);
        }
    }
}
