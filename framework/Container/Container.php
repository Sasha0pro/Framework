<?php

namespace Framework\Container ;

use Framework\Container\Exceptions\ServiceNotFoundException;
use Framework\Container\Handlers\ContainerCacheHandler;
use Framework\Container\Handlers\ServiceHandler;

class Container implements ContainerInterface
{
    private array $services;

    public function __construct()
    {
        $cache = new ContainerCacheHandler();
        if (!$cache->check()) {
            $serviceHandler = new ServiceHandler();
            $this->services = $serviceHandler->getServices();
            $cache->create($this->services);
        }
        else {
            $this->services = $cache->get();
        }
    }

    /**
     * @throws ServiceNotFoundException
     */
    public function get(string $id): ?object
    {
        if ($this->has($id)) {
            return $this->services[$id];
        }
        else {
            throw new ServiceNotFoundException('Service not found', 404);
        }
    }

    public function getAll(): array
    {
        return $this->services;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}