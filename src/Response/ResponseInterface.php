<?php

namespace App\Response;

interface ResponseInterface
{
    public static function fromArray(array $data, int $statusCode = 200);
}
