<?php

namespace Framework;

class Router
{
    protected $routes = [];

    public function resiterRoute($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function get($uri, $controller)
    {
        $this->resiterRoute('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->resiterRoute('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->resiterRoute('PUT', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->resiterRoute('DELETE', $uri, $controller);
    }

    public function error($errorCode = 404)
    {
        http_response_code($errorCode);
        loadView("error/{$errorCode}");
        exit;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if (strtolower($route['uri']) === $uri && $route['method'] === $method) {
                require(basePath('App/' . $route['controller']));
                return;
            }
        }

        $this->error();
    }
}
