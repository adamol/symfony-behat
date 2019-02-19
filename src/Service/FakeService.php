<?php

namespace App\Service;

class FakeService implements MyServiceInterface
{

    public function getMessage(): string
    {
        return 'fake';
    }
}

