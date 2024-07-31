<?php

namespace App\Model;

use App\Controller\MainController;

class User
{
    private ?string $username;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

}