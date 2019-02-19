<?php

namespace App\Service;

class MyService implements MyServiceInterface
{

    public function getMessage(): string
    {
        return 'world';
    }
}
