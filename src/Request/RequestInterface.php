<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestInterface
{
    public static function fromRequest(Request $request);
}
