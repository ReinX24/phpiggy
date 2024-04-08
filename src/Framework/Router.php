<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normalizePath($path);

        // Add an array within the $routes array
        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method),
            "controller" => $controller
        ];
    }

    private function normalizePath(string $path): string
    {
        // Removes slashes at the start and end of the string
        $path = trim($path, "/");
        $path = "/{$path}/";
        // If the backslash appears more than 2 times, replace with /
        $path = preg_replace("#[/]{2,}#", "/", $path);

        return $path;
    }

    public function dispatch(string $path, string $method)
    {
        // Send a request to the recorded paths and methods
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            // Checks if the stored path in $route is not the same as $path
            if (
                !preg_match("#^{$route["path"]}$#", $path) ||
                $route["method"] !== $method
            ) {
                continue; // goes to next item in the array
            }

            // A match is found
            // Get classname and method name with array destructuring
            [$class, $function] = $route["controller"];

            $controllerInstance = new $class;

            $controllerInstance->{$function}();
        }

    }
}