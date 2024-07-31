<?php

namespace Framework\Routing\Attribute;

use Attribute;

#[Attribute]
class Route
{
    public function __construct
    (
        private readonly string $path,
        private readonly string $type
    )
    {}

    public function getPath(): string
    {
        return $this->path;
    }

    public function getType(): string
    {
        return $this->type;
    }
}