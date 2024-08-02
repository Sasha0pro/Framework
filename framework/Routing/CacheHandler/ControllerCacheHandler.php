<?php

namespace Framework\Routing\CacheHandler;

use Framework\ORM\RedisConnection;
use Predis\Client;

class ControllerCacheHandler
{
    public Client $redis;
    const string NAME = 'controllers';

    public function __construct()
    {
        $this->redis = RedisConnection::getConnection();
    }

    public function get(): false|array
    {
        return unserialize(trim($this->redis->get(self::NAME), "'"));
    }

    public function create(array $controllers): void
    {
        $json = '\'' . serialize($controllers) . '\'';
        $this->redis->set(self::NAME, $json);
    }

    public function check(): bool
    {
        return $this->get() != false;
    }
}