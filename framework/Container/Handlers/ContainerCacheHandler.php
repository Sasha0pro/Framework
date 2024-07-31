<?php

namespace Framework\Container\Handlers;

use Framework\Controller\AbstractController;

class ContainerCacheHandler
{
    private string $pathFile;

    public function __construct()
    {
        $this->pathFile = dirname(__DIR__) . '/../../var/ContainerCache.txt';
    }

    public function create(array $services): void
    {
        file_put_contents($this->pathFile, serialize($services));
    }

    public function delete()
    {

    }

    public function get()
    {
        return unserialize(file_get_contents($this->pathFile));
    }

    public function check(): bool
    {
        return file_exists($this->pathFile);
    }
}