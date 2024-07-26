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
        return unserialize(trim($this->redis->get('Controllers'), "'"));
    }

    public function create(array $controllers): void
    {
        $json = "'" . serialize($controllers) . "'";
        $this->redis->set('Controllers', $json);
    }

    public function check(): bool
    {
        return $this->get() != false;
    }
}