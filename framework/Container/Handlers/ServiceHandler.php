<?php

namespace Framework\Container\Handlers;

use Framework\Container\Exceptions\ServiceNotFoundException;
use ReflectionClass;
use ReflectionException;

class ServiceHandler
{
    private array $services;

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     */
    public function __construct()
    {
        $directory = dirname(__DIR__) . '/../../src';
        $this->servicesLoad($directory);
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     */
    public function servicesLoad(string $directory): void
    {
        if ($d = opendir($directory)) {
            while (($file = readdir($d))) {
                $path = $directory . '/' . $file;
                if ($file === '.' || $file === '..' || $directory === dirname(__DIR__) . '/../src/Model') {
                    continue;
                }
                else if (filetype($path) === 'dir') {
                    $this->servicesLoad($path);
                }
                else if (filetype($path) === 'file') {
                    $this->setServices($path);
                }
            }
        }
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     */
    public function setServices(string $pathService): void
    {
        $pathHandler = new PathHandler();
        $pathParameterObjects = [];
        $namespaceObject = $pathHandler->AbsolutePathToNamespace($pathService);
        if (!$this->has($namespaceObject)) {
            $reflectionClass = new ReflectionClass($namespaceObject);
            if ($reflectionClass->getConstructor() !== null) {
                foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                    if ($parameter->hasType()) {
                        $type = $parameter->getType()->getName();
                        if ($type !== 'string' && $type !== 'array' && $type !== 'object') {
                            $pathParameterObjects[] = $type;
                        }
                    }
                }
            }
            if ($pathParameterObjects === []) {
                $this->services[$namespaceObject] = new $namespaceObject();
            }
            else {
                foreach ($pathParameterObjects as $pathParameterObject) {
                    if ($this->has($pathParameterObject)) {
                        $this->services[$namespaceObject] = new $namespaceObject($this->services[$pathParameterObject]);
                    } else {
                        $this->setServices($pathHandler->NamespaceToAbsolutePath($pathParameterObject));
                        $this->setServices($pathService);
                    }
                }
            }
        }
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function getServices(): array
    {
        return $this->services;
    }
}