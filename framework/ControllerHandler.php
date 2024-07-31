<?php

namespace Framework;

use Exception;
use Framework\Container\Container;
use Framework\Controller\AbstractController;
use Framework\Routing\Attribute\Route;
use Framework\Routing\CacheHandler\ControllerCacheHandler;
use ReflectionClass;

class ControllerHandler
{
    /**
     * @throws Exception
     */
    public function getControllers(): array
    {
        $controllers = null;
        $container = new Container();
        $cache = new ControllerCacheHandler();
        if ($cache->check()) {
            $controllers = $cache->get();
        }
        else {
            foreach ($container->getAll() as $service) {
                if ($service instanceof AbstractController) {
                    $attributes = $this->getAttributes($service);
                    foreach ($attributes as $method => $attribute) {
                        $controllers[$attribute->getPath()] = ['method' => $method, 'controller' => $service, 'type' => $attribute->getType()];
                    }
                }
            }
            $cache->create($controllers);
        }

        return $controllers;
    }

    /**
     * @throws Exception
     */
    public function getAttributes(AbstractController $controller): array
    {
        $attributes = [];
        $reflectionClass = new ReflectionClass($controller);

        foreach ($reflectionClass->getMethods() as $method) {
            if ($method->isPublic()) {
                foreach ($method->getAttributes() as $attribute) {
                    if ($attribute->getName() === Route::class) {
                        if ($attribute->isRepeated()) {
                            throw new Exception('Attribute Route more than one');
                        } else {
                            $attributes[$method->getName()] = $attribute->newInstance();
                        }
                    }
                }
            }
        }

        return $attributes;
    }

    /**
     * @throws Exception
     */
    public function getController(string $path)
    {
        $controllers = $this->getControllers();

        return $controllers[$path];
    }
}