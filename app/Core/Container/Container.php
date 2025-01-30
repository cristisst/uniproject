<?php
declare(strict_types=1);

namespace App\Core\Container;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;

class Container implements ContainerInterface
{
    /**
     * @var array The container's registered bindings.
     */
    protected array $instances = [];

    /**
     * Registers a binding in the container.
     *
     * @param string $id The identifier of the entry.
     * @param callable|object|string $concrete The concrete instance or factory.
     */
    public function set(string $id, $concrete): void
    {
        $this->instances[$id] = $concrete;
    }

    /**
     * Resolves and retrieves an entry by its identifier.
     *
     * @param string $id The identifier of the entry.
     * @return mixed The resolved entry.
     * @throws NotFoundException
     * @throws ContainerException
     */
    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new NotFoundException("No entry found for '$id'.");
        }

        $entry = $this->instances[$id];

        // If the entry is a callable (factory), call it.
        if (is_callable($entry)) {
            return $entry($this);
        }

        // If it's an object, return it as is.
        if (is_object($entry)) {
            return $entry;
        }

        // If it's a class name, instantiate it.
        if (is_string($entry) && class_exists($entry)) {
            return $this->resolve($entry);
        }

        // if it's a config property just return its value
        if (is_string($entry) || is_array($entry)) {
            return $entry;
        }

        throw new ContainerException("Unable to resolve entry '$id'.");
    }

    /**
     * Checks if the container has an entry for the given identifier.
     *
     * @param string $id The identifier of the entry.
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    /**
     * Resolves a class, including its dependencies.
     *
     * @param string $class The class name.
     * @return object The resolved class instance.
     * @throws ContainerException|NotFoundException
     */
    private function resolve(string $class): object
    {
        try {
            $reflectionClass = new ReflectionClass($class);

            // If the class doesn't have a constructor, return a new instance.
            if (!$reflectionClass->getConstructor()) {
                return new $class;
            }

            $constructor = $reflectionClass->getConstructor();
            $parameters = $constructor->getParameters();

            // Resolve each parameter of the constructor.
            $dependencies = array_map(function (ReflectionParameter $parameter) use ($class) {
                $type = $parameter->getType();

                if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                    throw new ContainerException("Cannot resolve class dependency {$parameter->getName()} for class $class.");
                }

                return $this->get($type->getName());
            }, $parameters);

            // Create a new instance with the resolved dependencies.
            return $reflectionClass->newInstanceArgs($dependencies);

        } catch (ReflectionException $e) {
            throw new ContainerException("Error resolving class $class: " . $e->getMessage());
        }
    }

    /**
     * Loads a configuration file and registers its values as bindings in the container.
     *
     * @param string $configDirectory
     * @throws ContainerException
     */
    public function loadConfig(string $configDirectory): void
    {
        if (!is_dir($configDirectory)) {
            throw new ContainerException("Configuration directory not found at $configDirectory");
        }

        // Get all PHP files in the directory
        $files = glob(rtrim($configDirectory, '/') . '/*.php');

        foreach ($files as $file) {
            /** @var array $config Configuration values must be an associative array. */
            $config = require $file;

            if (!is_array($config)) {
                throw new ContainerException("Configuration file $file must return an array.");
            }

            // Bind each configuration value to the container
            foreach ($config as $key => $value) {
                $this->set($key, $value);
            }
        }
    }
}
