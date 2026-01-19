<?php

declare(strict_types=1);

class Router
{
    /** @var array<string, array<int, array{pattern:string, handler:callable}>> */
    private array $routes = [];

    public function get(string $pattern, callable $handler): self
    {
        return $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, callable $handler): self
    {
        return $this->add('POST', $pattern, $handler);
    }

    public function dispatch(string $method, string $path): bool
    {
        $method = strtoupper($method);
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route) {
            if (preg_match($route['pattern'], $path, $matches) === 1) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return true;
            }
        }

        return false;
    }

    private function add(string $method, string $pattern, callable $handler): self
    {
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'handler' => $handler,
        ];

        return $this;
    }
}
