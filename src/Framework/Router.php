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
        // Removes slashes at the start and end of the string
        $path = trim($path, "/");
        $path = "/{$path}/";
        // If the backslash appears more than 2 times, replace with /
        $path = preg_replace("#[/]{2,}#", "/", $path);

        return $path;
    }
}