<?php

namespace Framework\Routing;

use Exception;
use Framework\HTTP\Request\Request;
use Framework\LoadController;

class Router
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function addRoute(): void
    {
        $loadController = new LoadController();
        $controllers = $loadController->load();
        $path = $this->getPath();

        foreach ($controllers as $controller) {
           $methodsAndAttributes = $loadController->getMethodsAndAttributes($controller);
            foreach ($methodsAndAttributes as $key => $method) {
                if ($path === $method->getPath()) {
                    if ($method->getType() === $this->request->getType()) {
                        echo $controller->$key();
                    }
                    else {
                        throw new Exception('HTTP method does not match', 404);
                    }
                }
                else {
                    throw new Exception('Route not found', 404);
                }
            }
        }
    }

    public function getPath(): ?string
    {
        $path = strstr($this->request->getPath(), '?', true);

        return $path === false ? $this->request->getPath() : $path;
    }

}