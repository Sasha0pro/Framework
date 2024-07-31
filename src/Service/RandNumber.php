<?php

namespace App\Service;

class RandNumber
{
    public function rand()
    {
        return rand(1, 1000);
    }
}