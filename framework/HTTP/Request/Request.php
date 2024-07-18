<?php

namespace Framework\HTTP\Request;


use Framework\HTTP\Request\HttpMethods\PostMethods;

class Request
{
    private string $path;

    private array $httpMethod;
    private string $type;

    public function __construct()
    {
        $this->path = $_SERVER["REQUEST_URI"];
        $this->type = $_SERVER['REQUEST_METHOD'];
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getHttpMethod($key = null): string|array
    {
        return $key === null ? $this->httpMethod : $this->httpMethod[$key];
    }

    public function setHttpMethod(string $method): Request
    {
        if ($method === "PUT") {
            $this->httpMethod = str_split(file_get_contents('php://input'));
        }
        else if ($method === "DELETE") {
            // в разработке
        }
        else if ($method === "POST") {
            $this->httpMethod = $_POST;
        }
        else if ($method === "GET"){
            $this->httpMethod = $_GET;
        }

        return $this;
    }


}