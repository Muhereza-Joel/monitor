<?php

namespace core\container;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    private array $instances = [];
    private array $factories = [];
    private array $bindings = [];

    public function set(string $id, $instance): void
    {
        $this->instances[$id] = $instance;
    }

    public function setFactory(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
    }

    public function bind(string $id, string $className, array $parameters = []): void
    {
        $this->bindings[$id] = ['class' => $className, 'params' => $parameters];
    }

    public function get(string $id, array $runtimeParameters = [])
    {
        if ($this->has($id)) {
            if (isset($this->instances[$id])) {
                return $this->instances[$id];
            }

            if (isset($this->factories[$id])) {
                return $this->factories[$id]($this);
            }

            if (isset($this->bindings[$id])) {
                return $this->resolve($id, $runtimeParameters);
            }
        }

        throw new NotFoundException("No entry found for '$id'.");
    }


    public function has(string $id): bool
    {
        return isset($this->instances[$id]) || isset($this->factories[$id]) || isset($this->bindings[$id]);
    }

    private function resolve(string $id, array $runtimeParameters = [])
    {
        if (!isset($this->bindings[$id])) {
            throw new NotFoundException("No binding found for '$id'.");
        }

        $binding = $this->bindings[$id];
        $className = $binding['class'];
        $parameters = $binding['params'];

        $reflector = new ReflectionClass($className);

        if (!$reflector->isInstantiable()) {
            throw new \RuntimeException("Class $className is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $className;
        }

        $params = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($params, $parameters, $runtimeParameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    private function resolveDependencies(array $parameters, array $bindings, array $runtimeParameters = [])
    {
        $dependencies = [];
        foreach ($parameters as $param) {
            $name = $param->getName();

            // 1. Check if runtime parameters were passed for this dependency
            if (isset($runtimeParameters[$name])) {
                $dependencies[] = $runtimeParameters[$name];
            }
            // 2. Check if bindings have this dependency
            elseif (isset($bindings[$name])) {
                $dependencies[] = $bindings[$name];
            }
            // 3. Check if the parameter is a class dependency (autowiring)
            elseif ($param->getClass()) {
                $dependencies[] = $this->get($param->getClass()->name);
            }
            // 4. Check if the parameter has a default value
            elseif ($param->isDefaultValueAvailable()) {
                $dependencies[] = $param->getDefaultValue();
            } else {
                throw new \RuntimeException("Cannot resolve dependency '{$name}'.");
            }
        }

        return $dependencies;
    }

    public function autoRegister(string $directory, string $namespacePrefix)
    {
        $files = glob($directory . '/*.php');

        foreach ($files as $file) {
            $relativePath = str_replace([$directory . '/', '.php'], ['', ''], $file);
            $className = $namespacePrefix . str_replace('/', '\\', $relativePath);

            if (class_exists($className)) {
                $this->bind($className, $className);
            }
        }
    }
}

class NotFoundException extends \RuntimeException implements NotFoundExceptionInterface {}

class ContainerException extends \RuntimeException implements ContainerExceptionInterface {}
