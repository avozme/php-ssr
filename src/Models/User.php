<?php

namespace App\Models;

class User extends BaseModel
{
    public function __construct(\Database $database)
    {
        parent::__construct($database, 'usuarios');
    }

    public function findByEmail(string $email, string $password): ?int
    {
        $user = $this->database->fetchOne(
            'SELECT `id`, `password` FROM `usuarios` WHERE `email` = ?',
            [$email]
        );

        if ($user === null || !password_verify($password, $user['password'])) {
            return null;
        }

        return (int) $user['id'];
    }
}
