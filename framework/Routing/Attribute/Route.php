<?php

namespace Framework\Routing\Attribute;

use Attribute;

#[Attribute]
class Route
{
    private string $path;
    private string $type;
    public function __construct(string $path, string $type)
    {
        $this->path = $path;
        $this->type = $type;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getType(): string
    {
        return $this->type;
    }
}