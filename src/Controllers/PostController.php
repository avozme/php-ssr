<?php

namespace App\Controllers;

use App\Models\Post;

class PostController
{
    private Post $post;
    private ?string $error = null;
    private ?array $currentPost = null;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index(): void
    {
        $term = trim($_GET['q'] ?? '');
        $posts = $term === '' ? $this->post->getAll() : $this->post->search($term);

        require dirname(__DIR__) . '/Views/posts/index.php';
    }

    public function show(): void
    {
        $this->currentPost = $this->findPost();
        if ($this->currentPost === null) {
            return;
        }

        require dirname(__DIR__) . '/Views/posts/show.php';
    }

    public function create(): void
    {
        if (!$this->requireLogin()) {
            return;
        }

        require dirname(__DIR__) . '/Views/posts/create.php';
    }

    public function store(): void
    {
        if (!$this->requireLogin()) {
            return;
        }

        [$title, $body, $category] = $this->postData();
        if (!$this->validPostData($title, $body, $category)) {
            require dirname(__DIR__) . '/Views/posts/create.php';
            return;
        }

        $this->post->insert([
            'usuario_id' => (int) $_SESSION['id'],
            'titulo' => $title,
            'cuerpo' => $body,
            'categoria' => $category,
        ]);

        header('Location: /?action=posts');
        exit;
    }

    public function edit(): void
    {
        if (!$this->requireOwner()) {
            return;
        }

        require dirname(__DIR__) . '/Views/posts/edit.php';
    }

    public function update(): void
    {
        if (!$this->requireOwner()) {
            return;
        }

        [$title, $body, $category] = $this->postData();
        if (!$this->validPostData($title, $body, $category)) {
            require dirname(__DIR__) . '/Views/posts/edit.php';
            return;
        }

        $this->post->update((int) $this->currentPost['id'], [
            'titulo' => $title,
            'cuerpo' => $body,
            'categoria' => $category,
        ]);

        header('Location: /?action=post&id=' . (int) $this->currentPost['id']);
        exit;
    }

    public function destroy(): void
    {
        if (!$this->requireOwner()) {
            return;
        }

        $this->post->delete((int) $this->currentPost['id']);

        header('Location: /?action=posts');
        exit;
    }

    private function requireLogin(): bool
    {
        if (isset($_SESSION['id'])) {
            return true;
        }

        header('Location: /?action=login&message=auth_required');
        exit;
    }

    private function requireOwner(): bool
    {
        if (!$this->requireLogin()) {
            return false;
        }

        $this->currentPost = $this->findPost();
        if ($this->currentPost === null) {
            return false;
        }

        if ((int) $this->currentPost['usuario_id'] !== (int) $_SESSION['id']) {
            http_response_code(403);
            echo 'Prohibido: no tienes permiso para realizar esta acción.';
            return false;
        }

        return true;
    }

    private function findPost(): ?array
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null || $id < 1) {
            http_response_code(404);
            echo 'Publicación no encontrada.';
            return null;
        }

        $post = $this->post->getById($id);
        if ($post === null) {
            http_response_code(404);
            echo 'Publicación no encontrada.';
            return null;
        }

        return $post;
    }

    private function postData(): array
    {
        return [
            trim($_POST['titulo'] ?? ''),
            trim($_POST['cuerpo'] ?? ''),
            trim($_POST['categoria'] ?? ''),
        ];
    }

    private function validPostData(string $title, string $body, string $category): bool
    {
        if ($title !== '' && $body !== '' && $category !== '') {
            return true;
        }

        $this->error = 'Completa el título, el contenido y la categoría.';
        return false;
    }
}
