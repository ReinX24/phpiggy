<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path)
    {
        $path = $this->normalizePath($path);

        // Add an array within the $routes array
        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method)
        ];
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, "/"); // removes any forward slashes
        $path = "/{$path}/";

        return $path;
    }
}