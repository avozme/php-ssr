<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private User $user;
    private ?string $error = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function showRegisterForm(): void
    {
        require dirname(__DIR__) . '/Views/auth/register.php';
    }

    public function register(): void
    {
        $name = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $this->error = 'Introduce un nombre, un email válido y una contraseña.';
            $this->showRegisterForm();
            return;
        }

        $this->user->insert([
            'nombre' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        header('Location: ?action=login&registered=1');
        exit;
    }

    public function showLoginForm(): void
    {
        require dirname(__DIR__) . '/Views/auth/login.php';
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $id = $this->user->findByEmail($email, $password);
        if ($id === null) {
            $this->error = 'El email o la contraseña no son correctos.';
            $this->showLoginForm();
            return;
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_regenerate_id(true);
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;

        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        header('Location: /');
        exit;
    }
}
