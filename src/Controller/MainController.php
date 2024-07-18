<?php

namespace App\Controller;

use Framework\Controller\Controller;
use Framework\HTTP\Request\Request;
use Framework\Routing\Attribute\Route;

class MainController extends Controller
{
    #[Route('/main', 'GET')]
    public function main(): array
    {
        $request = new Request();

        return $request->getHttpMethod();
    }

}