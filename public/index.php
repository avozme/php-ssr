<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/src/Core/Database.php';

use App\Controllers\AuthController;
use App\Controllers\PostController;
use App\Models\Post;
use App\Models\User;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$database = new Database();
$authController = new AuthController(new User($database));
$postController = new PostController(new Post($database));
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->showRegisterForm();
        }
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLoginForm();
        }
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'posts':
        $postController->index();
        break;
    case 'post':
        $postController->show();
        break;
    case 'create-post':
        $postController->create();
        break;
    case 'store-post':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postController->store();
        } else {
            http_response_code(405);
            echo 'Método no permitido.';
        }
        break;
    case 'edit-post':
        $postController->edit();
        break;
    case 'update-post':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postController->update();
        } else {
            http_response_code(405);
            echo 'Método no permitido.';
        }
        break;
    case 'delete-post':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postController->destroy();
        } else {
            http_response_code(405);
            echo 'Método no permitido.';
        }
        break;
    case 'home':
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Tablón de anuncios</title>
        </head>
        <body>
            <?php require dirname(__DIR__) . '/src/Views/partials/header.php'; ?>
            <main>
                <h1>Tablón de anuncios</h1>
                <p><a href="/?action=posts">Ver publicaciones</a></p>
            </main>
        </body>
        </html>
        <?php
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada.';
}
