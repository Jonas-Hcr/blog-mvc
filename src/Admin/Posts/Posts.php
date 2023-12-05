<?php

namespace Jonashcr\Admin\Posts;

use Jonashcr\Infra\ConnectDB;

class Posts
{

    private function getPosts()
    {
        $connect = new ConnectDB();
        $db = $connect->getConnection();

        $stmt = $db->query("SELECT * FROM posts");
        $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $posts;
    }

    /**
     * Carrega a tabela de posts
     */
    public function index()
    {
        $posts = $this->getPosts();
        require ADMIN_VIEW . '/posts/index.phtml';
    }

    /**
     * Carrega o formulário de criação de posts
     */
    public function createForm()
    {
        require ADMIN_VIEW . '/posts/create-form.phtml';
    }

    /**
     * Cria um novo post
     */
    public function save()
    {
        $_SESSION['error'] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $slug = $_POST['slug'];
            $status = $_POST['status'];
            $content = $_POST['content'];
        
            $image = $this->saveImage($_FILES['image']['name']);
            if (!$image) {
                $_SESSION['error'] = "Falha ao salvar imagem";
                header("Location: /admin/posts");
                return;
            }

            $connect = new ConnectDB();
            $db = $connect->getConnection();
        
            $stmt = $db->prepare("INSERT INTO posts (title, slug, content, status, image) VALUES (:title, :slug, :content, :status, :image)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':image', $target);
            $stmt->execute();
        
            header('Location: /admin/posts');
            exit();
        }
    }

    private function saveImage($post_image): string|bool
    {
        $target = BLOG_VIEW . "/assets/posts/" . basename($post_image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            return false;
        }
        return $target;
    }

    /**
     * Carrega o formulário de editar posts
     */
    public function edit()
    {
        $_SESSION['error'] = '';
        $postId = $_GET['id'];

        $connect = new ConnectDB();
        $db = $connect->getConnection();

        $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $postId);
        $stmt->execute();

        $post = $stmt->fetch(\PDO::FETCH_ASSOC);

        require ADMIN_VIEW . '/posts/edit-form.phtml';
    }

    /**
     * Atualiza um post
     */
    public function update()
    {
        $_SESSION['error'] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['id'];
            $title = $_POST['title'];
            $slug = $_POST['slug'];
            $status = $_POST['status'];
            $content = $_POST['content'];

            $connect = new ConnectDB();
            $db = $connect->getConnection();

            $query = "UPDATE posts SET title = :title, slug = :slug, content = :content, `status` = :status, ";

            $image = false;
            if (!empty($_FILES['image']) && $_FILES['image']['name']) {
                $image = $this->saveImage($_FILES['image']['name']);
                if (!$image) {
                    $_SESSION['error'] = "Falha ao editar imagem";
                    header("Location: /admin/posts");
                    return;
                }
            }

            if ($image) {
                $query .= "`image` = :image ";
            }
            $query .= "WHERE id = :id";

            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $postId);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':status', $status);
            if ($image) {
                $stmt->bindParam(':image', $image);
            }

            $stmt->execute();

            header('Location: /admin/posts');
            exit();
        }
    }

    /**
     * Exclui um post
     */
    public function delete()
    {
        $_SESSION['error'] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['id'];

            $connect = new ConnectDB();
            $db = $connect->getConnection();

            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            header('Location: /admin/posts');
            exit();
        }
    }
}
