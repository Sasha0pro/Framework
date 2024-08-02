<?php

namespace Framework\ORM;

use Predis\Client;

class RedisConnection
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new Client('redis://localhost');
        }
        return self::$connection;
    }
}