<?php

namespace Core;

class Router
{
    protected $routes = [];

    public function add($method, $route, $action)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => $route,
            'action' => $action
        ];
    }

    public function dispatch($url)
    {
        $url = parse_url($url, PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        foreach ($this->routes as $routeData) {
            if ($routeData['method'] !== $requestMethod) continue;

            $route = $routeData['route'];
            $action = $routeData['action'];

            // Ubah format route /accounts/edit/{id} menjadi regex
            $pattern = preg_replace('/\{[a-zA-Z0-9]+\}/', '([a-zA-Z0-9]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                
                list($controller, $method) = explode('@', $action);

                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        return call_user_func_array([$controllerInstance, $method], $matches);
                    }
                }
            }
        }

        http_response_code(404);
        die("404 Halaman Tidak Ditemukan");
    }
}
