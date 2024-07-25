<?php

namespace Framework\Routing\CacheHandler;

use Predis\Client;

class ControllerCacheHandler
{
    public Client $redis;

    public function __construct()
    {
        $this->redis = new Client('redis://localhost');
    }

    public function get(): false|array
    {
        return unserialize($this->redis->get('Controllers'));
    }

    public function create(array $controllers): void
    {
        $this->redis->set('Controllers', serialize($controllers));
    }

    public function check(): bool
    {
        return $this->get() != false;
    }
}