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
     * initRoutes
     * @throws Exception
     */
    public function addRoute(): void
    {
        $ControllerHandler = new ControllerHandler();
        $controllers = $ControllerHandler->load();
        $path = $this->getPath();
        $response = null;

        foreach ($controllers as $controller) {
            $attributes = $ControllerHandler->getAttributes($controller);
            foreach ($attributes as $method => $attribute) {
                if ($path === $attribute->getPath() && $attribute->getType() === $this->request->getType()) {
                    $response = $controller->$method();
                }
            }
        }
        $this->checkResponse($response);
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
    public function checkResponse($response): void
    {
        if ($response === null) {
            // Завести енам для HTTP кодов
            throw new Exception('Route not found', 404);
        }
    }
}