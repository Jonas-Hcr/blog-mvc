<?php

namespace Jonashcr\Admin\Users;

use Jonashcr\Infra\ConnectDB;

class Users
{

    private function getUsers()
    {
        $connect = new ConnectDB();
        $db = $connect->getConnection();

        $stmt = $db->query("SELECT * FROM users");
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $users;
    }
    
    /**
     * Carrega a tabela de usuários
     */
    public function index()
    {
        $users = $this->getUsers();
        require ADMIN_VIEW . '/users/index.phtml';
    }

    /**
     * Carrega o formulário de criação de usuários
     */
    public function createForm()
    {
        require ADMIN_VIEW . '/users/create-form.phtml';
    }

    /**
     * Cria um novo usuário
     */
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = $_POST['role'];

            $connect = new ConnectDB();
            $db = $connect->getConnection();

            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            header('Location: /admin/user');
            exit();
        }
    }

    /**
     * Carrega o formulário de editar usuários
     */
    public function edit()
    {
        $userId = $_GET['id'];

        $connect = new ConnectDB();
        $db = $connect->getConnection();

        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        require ADMIN_VIEW . '/users/edit-form.phtml';
    }

    /**
     * Atualiza um usuário
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            $connect = new ConnectDB();
            $db = $connect->getConnection();

            $stmt = $db->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header('Location: /admin/user');
            exit();
        }
    }

    /**
     * Exclui um usuário
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['id'];

            $connect = new ConnectDB();
            $db = $connect->getConnection();

            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            header('Location: /admin/user');
            exit();
        }
    }
}
