<?php

namespace App\Controller;

use App\Model\User;
use Framework\Controller\AbstractController;
use Framework\Routing\Attribute\Route;

class MainController extends AbstractController
{
    public function __construct
    ()
    {}

    #[Route('/main', 'GET')]
    public function main(): string
    {
        return '11111';
    }
}