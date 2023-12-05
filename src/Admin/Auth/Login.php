<?php

namespace Jonashcr\Admin\Auth;

use Jonashcr\Admin\Users\User;
use Jonashcr\Infra\ConnectDB;
use PDO;

class Login
{
    /**
     * Chama a view de login
     */
    public function index()
    {
        $_SESSION['login_error'] = '';

        require ADMIN_VIEW . '/auth/login.phtml';
    }

    /**
     * Valida o usuário ao realizar o login
     * 
     * @var array $request
     * @return void
     */
    public function auth($request): void
    {
        $email = $request['email'];
        $password = $request['password'];
    
        $connect = new ConnectDB();
        $db = $connect->getConnection();
    
        $stmt = $db->prepare("SELECT * FROM users WHERE  email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // obter resultados com um array associativo
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            new User(
                $user['id'],
                $user['username'],
                $user['role']
            );

            header('Location: /admin/home');
            return;
        } else {
            $_SESSION['login_error'] = 'Falha no login. Verifique seu nome de usuário/e-mail e senha.';
            header('Location: /admin/login');
        }
    }
}
