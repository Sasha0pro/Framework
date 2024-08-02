<?php

namespace Framework\Container\Handlers;

use Framework\Container\Exceptions\InvalidParameterException;
use Framework\Container\Exceptions\ServiceNotFoundException;
use ReflectionClass;
use ReflectionException;

class ServiceHandler
{
    private array $services;

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     * @throws InvalidParameterException
     */
    public function __construct(private readonly PathHandler $pathHandler = new PathHandler())
    {
        $directory = dirname(__DIR__) . '/../../src';
        $this->searchFile($directory);
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     * @throws InvalidParameterException
     */
    public function searchFile(string $directory): void
    {
        if ($d = opendir($directory)) {
            while (($file = readdir($d))) {
                $path = $directory . '/' . $file;
                if ($file === '.' || $file === '..' || $directory === dirname(__DIR__) . '/../src/Model') {
                    continue;
                } elseif (filetype($path) === 'dir') {
                    $this->searchFile($path);
                } elseif (filetype($path) === 'file') {
                    $class = $this->pathHandler->absolutePathToNamespace($path);
                    $this->services[$class] = $this->getService($class);
                }
            }
        }
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     * @throws InvalidParameterException
     */
    public function initService(string $class): mixed
    {
        $pathParameterObjects = [];
        $reflectionClass = new ReflectionClass($class);
        if ($reflectionClass->getConstructor() !== null) {
            foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                if ($parameter->hasType() && !$parameter->getType()->isBuiltin()) {
                    $pathParameterObjects[] = $this->getService($parameter->getType()->getName());
                } else {
                    throw new InvalidParameterException('invalid constructor parameter');
                }
            }
        }
        return $this->services[$class] = new $class(...$pathParameterObjects);
    }

    /**
     * @throws InvalidParameterException
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     */
    public function getService(string $id): object
    {
        return $this->services[$id] ?? $this->initService($id);
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
