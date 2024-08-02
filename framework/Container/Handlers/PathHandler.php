<?php

namespace Framework\Container\Handlers;

class PathHandler
{
    public function absolutePathToNamespace(string $absolutePath): string
    {
        $pathObject = trim(strstr($absolutePath, 'src'), 'src');
        $pathObject = 'App' . str_replace('/', '\\', $pathObject);

        return trim($pathObject, '.ph');
    }
}