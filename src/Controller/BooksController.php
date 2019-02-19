<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BooksController extends AbstractController
{
    /**
    * @Route("/books", methods={"POST"})
    */
    public function storeAction(Request $request)
    {
        return new JsonResponse([
            'title' => $request->get('title'),
            'author' => $request->get('author'),
            'enabled' => $request->get('enabled'),
        ], 201);
    }
}
