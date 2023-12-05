<?php

namespace Jonashcr\Infra\Routes;

use Jonashcr\Admin\Auth\Login;
use Jonashcr\Admin\Posts\Posts;
use Jonashcr\Admin\Users\User;
use Jonashcr\Admin\Users\Users;
use Jonashcr\Setup\Setup;

class RouteSwitch
{
    static public function validateRole($role = 'Admin')
    {
        return User::$role == $role;
    }

    protected function home()
    {
        require __DIR__ . '../../../blog/index.php';
    }

    protected function admin()
    {
        if ($this->validUser()) {
            $this->admin_home();
            return;
        }
        header('Location: admin/login');
        $this->admin_login();
    }

    protected function admin_login()
    {
        if ($this->validUser()) {
            $this->admin_home();
            return;
        }

        $login = new Login();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login->auth($_POST);
            header('Location: /admin/home');
            return;
        }

        $login->index();
    }

    protected function admin_home()
    {
        if ($this->validUser()) {
            require ADMIN_VIEW . '/index.phtml';
            return;
        }
        header('Location: /admin/login');
        $this->admin_login();
    }

    protected function admin_user()
    {
        if (!$this->validUser()) {
            $this->admin_login();
            return;
        }

        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if (!empty($action) && !RouteSwitch::validateRole()) {
            $this->__call('', '');
            return;
        }

        $this->defineAction(new Users(), $action);
    }

    protected function admin_posts()
    {
        if (!$this->validUser()) {
            $this->admin_login();
            return;
        }

        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if (!empty($action) && !RouteSwitch::validateRole()) {
            $this->__call('', '');
            return;
        }

        $this->defineAction(new Posts(), $action);
    }

    private function defineAction($controller, String $action)
    {
        match ($action) {
            'createForm' => $controller->createForm(),
            'save' => $controller->save(),
            'edit' => $controller->edit(),
            'update' => $controller->update(),
            'delete' => $controller->delete(),
            default => $controller->index(),
        };
    }

    protected function validUser()
    {
        return isset($_SESSION['user_id']);
    }

    protected function setup()
    {
        $setup = new Setup();
        $setup->run();
    }

    public function __call($name, $arguments)
    {
        http_response_code(404);
        require __DIR__ . '../../../Blog/404.php';
    }
}
