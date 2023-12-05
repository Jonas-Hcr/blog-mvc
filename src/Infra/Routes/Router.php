<?php

namespace Jonashcr\Infra\Routes;

use Jonashcr\Infra\Routes\RouteSwitch;

class Router extends RouteSwitch
{
    public function run(string $requestUri)
    {
        $route = substr($requestUri, 1);

        if (preg_match('/\.(jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx)$/i', $route)) {
            $this->readFile($route);
            return;
        }

        $route = parse_url($route)['path'] ?? '';
        $route = str_replace('/', '_', $route);

        if ($route === '') {
            $this->home();
        } else {
            $this->$route();
        }
    }

    /**
     * Caso seja uma imagem ou arquivo, ele renderiza ao 
     * invés de enviar a um método
     */
    private function readFile(String $route): void
    {
        $route = str_replace('admin', 'Admin', $route);
        $route = str_replace('blog', 'Blog', $route);

        if (file_exists($route) && !in_array(pathinfo($route, PATHINFO_EXTENSION), ['php', 'phtml'])) {
            header('Content-Type: ' . mime_content_type($route));
            readfile($route);
            exit();
        }
        
        echo "<p>Arquivo não encontrado</p>";
        return;
    }
}
