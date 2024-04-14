<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\ContainerException;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

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

        // Array that will contain the parameters for our controller
        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve class 
                {$className} because {$name} is missing a type hint.");
            }

            // Checks if the type exists and not a ReflectionNamedType.
            // Also checks if the type is a built in PHP data type, not a 
            // custom type from a class.
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve class 
                {$className} because invalid param name.");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} does not exist in container.");
        }

        // Checks if an instance exists
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }

        // Items in the array are factory functions, functions that return an
        // instance of a class.
        $factory = $this->definitions[$id];

        $dependency = $factory(); // creates an instance of the class

        $this->resolved[$id] = $dependency;

        return $dependency;
    }
}
