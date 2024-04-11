<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;
use Framework\Exceptions\ContainerException;

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

        // Check if the class is not an abstract class
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$className} is not instantiable.");
        }

        // Runs the constructor method of the class
        $constructor = $reflectionClass->getConstructor();

        // Runs if the constructor does not exist
        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters();

        // If no parameters are found
        if (count($params) === 0) {
            return new $className;
        }

        dd($params);
    }
}
