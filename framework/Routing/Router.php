<?php

namespace Framework\Routing;

use Exception;
use Framework\HTTP\Request\Request;
use Framework\ControllerHandler;

class Router
{
    public function __construct(private readonly Request $request)
    {}

    /**
     * @throws Exception
     */
    public function initRouters(): void
    {
        $ControllerHandler = new ControllerHandler();
        $controller = $ControllerHandler->getController($this->getPath());
        $this->checkController($controller);
        $method = $controller['method'];
        $response = $controller['controller']->$method();
        $this->response($response);
    }

    public function getPath(): ?string
    {
        $path = strstr($this->request->getPath(), '?', true);

        return $path === false ? $this->request->getPath() : $path;
    }

    public function response(mixed $response): void
    {
        echo $response;
    }

    /**
     * mixed
     * @throws Exception
     */
    public function checkController($controller): void
    {
        if ($controller === null) {
            // Завести енам для HTTP кодов
            throw new Exception('Route not found', 404);
        }
    }
}