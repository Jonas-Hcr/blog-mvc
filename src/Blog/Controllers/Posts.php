<?php

namespace Jonashcr\Blog\Controllers;

use Jonashcr\Infra\ConnectDB;

class Posts
{
    public function index()
    {
        $connect = new ConnectDB();
        $db = $connect->getConnection();

        $stmt = $db->query('SELECT * FROM posts WHERE status = 1');
        $posts = $stmt->fetchAll();

        require BLOG_VIEW . '/posts/index.phtml';
    }

    public function show($slug)
    {
        $connect = new ConnectDB();
        $db = $connect->getConnection();

        $stmt = $db->prepare('SELECT * FROM posts WHERE slug = :slug AND status = 1 LIMIT 1');
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();

        $post = $stmt->fetch();

        if (!$post) {
            header("Location: /src/Blog/404.php");
            exit();
        }

        require BLOG_VIEW . '/posts/show.phtml';
    }
}
