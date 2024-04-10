<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;

class Container
{
    private array $definitions = [];

    public function addDefinitions(array $newDefinitions)
    {
        // Merge new array into the existing array
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        dd($reflectionClass);
    }
}
