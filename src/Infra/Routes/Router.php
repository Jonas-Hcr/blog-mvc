<?php

namespace Jonashcr\Blog\Infra\Routes;

use Jonashcr\Blog\Infra\Routes\RouteSwitch;

class Router extends RouteSwitch
{
    public function run(string $requestUri)
    {
        $route = substr($requestUri, 1);

        if ($route === '') {
            $this->home();
        } else {
            $this->$route();
        }
    }
}