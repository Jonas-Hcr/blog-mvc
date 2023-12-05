<?php

namespace Jonashcr\Infra\Routes;

use Jonashcr\Admin\Auth\Login;
use Jonashcr\Setup\Setup;

class RouteSwitch
{
    protected function home()
    {
        require __DIR__ . '../../../blog/index.php';
    }

    protected function admin()
    {
        if (isset($_SESSION['user_id'])) {
            $this->admin_home();
            return;
        }
        header('Location: admin/login');
        $this->admin_login();
    }

    protected function admin_login()
    {
        $login = new Login();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login->auth($_POST);
            return;
        }

        $login->index();
    }

    protected function admin_home()
    {
        require ADMIN_VIEW . '/index.phtml';
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
