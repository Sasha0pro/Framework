<?php

namespace App\Controller;

use App\Service\RandNumber;
use Framework\Controller\AbstractController;
use Framework\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly RandNumber $randNumber)
    {}

    #[Route('/user', 'GET')]
    public function user(): string
    {
        return $this->randNumber->rand();
    }
}