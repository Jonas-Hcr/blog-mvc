<?php

/**
 * Classe responsável pelos dados do usuário logado. 
 * Utilizada para validar as $roles
 */

namespace Jonashcr\Admin\Users;

class User
{
    public static string $role;

    public function __construct(
        public int $id,
        public string $username,
        string $role,
    ) {
        self::$role = $role;
    }
}