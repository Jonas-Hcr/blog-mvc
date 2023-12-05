<?php

namespace Jonashcr\Infra\Routes;

use Jonashcr\Setup\Setup;

class RouteSwitch
{
    protected function home()
    {
        require __DIR__ . '../../../blog/index.php';
    }

    protected function admin()
    {
        require __DIR__ . '../../../admin/index.php';
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
