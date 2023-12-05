<?php

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