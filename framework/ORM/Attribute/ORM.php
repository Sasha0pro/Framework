<?php

namespace Framework\ORM\Attribute;

use Attribute;
use Exception;
use Framework\ORM\MysqlModel;

#[Attribute(Attribute::TARGET_CLASS)]
class ORM
{
    private string $table;
    private object $model;

    /**
     * @throws Exception
     */
    public function __construct(string $table, object $model)
    {
        $this->table = $table;
        if ($model instanceof MysqlModel) {
            $this->model = $model;
        }
        else {
            throw new Exception('the object is not an instance of the class MysqlModel');
        }
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getModel(): object
    {
        return $this->model;
    }
}