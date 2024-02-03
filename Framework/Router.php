<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router
{
    protected $routes = [];

    public function resiterRoute($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
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

    public function route($uri)
    {
        $Requestmethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $uriSegments = explode('/', trim($uri, '/'));
            $routeSegments = explode('/', trim($route['uri'], '/'));
            $match = true;

            if (count($uriSegments) === count($routeSegments) && $route['method'] === $Requestmethod) {
                $params = [];
                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFound();
    }
}
