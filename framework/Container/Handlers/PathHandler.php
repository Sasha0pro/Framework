<?php

namespace Framework\Container\Handlers;

class PathHandler
{
    public function AbsolutePathToNamespace(string $absolutePath): string
    {
        $pathObject = trim(strstr($absolutePath, 'src'), 'src');
        $pathObject = 'App' . str_replace('/', '\\', $pathObject);

        return trim($pathObject, '.ph');
    }

    public function NamespaceToAbsolutePath(string $namespace): string
    {
        $pathObject = trim($namespace, '\\Ap');
        $pathObject = str_replace('\\', '/', $pathObject);

        return dirname(__DIR__) . '/../src/' . $pathObject . '.php';
    }
}