<?php

namespace Framework\ORM;


use PDO;

class MySqlConnection
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new PDO('mysql:dbname=popita;host=localhost', 'root', 'root');
        }
        return self::$connection;
    }
}