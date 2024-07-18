<?php

namespace Framework;

use Framework\Controller\Controller;
use ReflectionClass;

class LoadController
{
    public function load(): array
    {
       $nameControllers = scandir(dirname(__DIR__) . '/src/Controller');
       $controllers = [];
        foreach ($nameControllers as $name) {
            if (strripos($name, 'Controller') !== false) {
                $path = trim("App\Controller\\" . $name, '.ph');
                $controllers[] = new $path();
            }
        }
        return $controllers;
    }

    public function getMethodsAndAttributes(Controller $controller): array
    {
        $methodsAndAttributes = [];
        $reflectionClass = new ReflectionClass($controller);

        foreach ($reflectionClass->getMethods() as $method) {
            foreach ($method->getAttributes() as $attribute) {
                $methodsAndAttributes[$method->getName()] = $attribute->newInstance();
            }
        }

        return $methodsAndAttributes;
    }
}