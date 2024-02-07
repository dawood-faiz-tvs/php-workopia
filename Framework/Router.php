<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router
{
    protected $routes = [];

    public function resiterRoute($method, $uri, $action, $middlewares)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middlewares' => $middlewares,
        ];
    }

    public function get($uri, $controller, $middlewares = [])
    {
        $this->resiterRoute('GET', $uri, $controller, $middlewares);
    }

    public function post($uri, $controller, $middlewares = [])
    {
        $this->resiterRoute('POST', $uri, $controller, $middlewares);
    }

    public function put($uri, $controller, $middlewares = [])
    {
        $this->resiterRoute('PUT', $uri, $controller, $middlewares);
    }

    public function delete($uri, $controller, $middlewares = [])
    {
        $this->resiterRoute('DELETE', $uri, $controller, $middlewares);
    }

    public function route($uri)
    {
        $Requestmethod = $_SERVER['REQUEST_METHOD'];

        if ($Requestmethod === 'POST' && isset($_POST['_method'])) {
            $Requestmethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            $uriSegments = explode('/', trim($uri, '/'));
            $routeSegments = explode('/', trim($route['uri'], '/'));
            $match = true;

            if (count($uriSegments) === count($routeSegments) && $route['method'] === strtoupper($Requestmethod)) {
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
                    foreach ($route['middlewares'] as $role) {
                        (new Authorize())->handle($role);
                    }

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
