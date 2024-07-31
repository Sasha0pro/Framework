<?php

namespace Framework\ORM;

use Framework\HTTP\Response\Encoder\NormalizeAndDenormalize;
use PDO;
use ReflectionClass;

// Active Record патерн
class MysqlModel
{
    protected $table = 'user';
    protected $connection;

    // nahuy
    private string $pathObject;

    private ReflectionClass $reflectionClass;

    public function __construct()
    {
        $this->connection = MySqlConnection::getConnection();
        $this->pathObject = $this::class;
    }

    // Репозитрии
    public function all(): false|array
    {
        $query = $this->connection->query("SELECT * FROM `{$this->table}`");

        return $query->fetchAll(PDO::FETCH_CLASS, $this->getPathObject());
    }

    /**
     * Query Builder
     */
    public function findBy(array $context): null|array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE ";
        foreach ($context as $key => $value) {
            $where = $key . ' = ' . $value;

            $sql = $sql . $where . ' ' . 'AND' . ' ';
        }
        $sql = rtrim($sql, ' AND');
        $query = $this->connection->query($sql);

        return $query->fetchAll(PDO::FETCH_CLASS, $this->getPathObject()) ?: null;
    }

    public function findByTest(array $context): null|array
    {
        $sql = "SELECT * FROM `{$this->table}`";
        if (!empty($context)) {
            $sql .= 'WHERE ';
            $whereSegments = [];
            foreach ($context as $key => $value) {
                 $whereSegments[] = $key . ' = ' . $value;
            }
            $sql .= implode(' AND ', $whereSegments);
        }

        foreach ($context as $key => $value) {
            $where = $key . ' = ' . $value;

            $sql = $sql . $where . ' ' . 'AND' . ' ';
        }
        $sql = rtrim($sql, ' AND');
        $query = $this->connection->query($sql);

        return $query->fetchAll(PDO::FETCH_CLASS, $this->getPathObject()) ?: null;
    }


    public function findOneBy(array $context): false|array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE ";
        foreach ($context as $key => $value) {
            $where = $key . '=' . $value;

            $sql = $sql . $where . ' ' . 'AND' . ' ';
        }
        $sql = rtrim($sql, ' AND');
        $sql = $sql . ' ' . 'LIMIT 1';
        $query = $this->connection->query($sql);

        return $query->fetchAll(PDO::FETCH_CLASS, $this->getPathObject());
    }

    public function getPathObject(): string
    {
        return $this->pathObject;
    }

    public function save()
    {
        $sql = "INSERT INTO `{$this->table}` VALUES ";
        $parent = $this->reflectionClass->getParentClass();
        foreach ($this->reflectionClass->getProperties() as $property) {
            $propertyValue = null;
            foreach ($parent->getProperties() as $parentProperty) {
                if ($property->getName() !== $parentProperty->getName()) {
                    $type = gettype($property->getValue($this));
                    if ($type === "array") {
                        $propertyValue = implode($property->getValue($this));
                    } else if ($type === "string") {
                        $propertyValue = $property->getValue($this);
                    }
                }
            }
            $sql = $sql . $property->getName() . '=' . $propertyValue . ' ';
        }
        var_dump($sql);

    }
}