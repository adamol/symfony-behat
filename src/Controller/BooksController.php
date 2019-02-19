<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\MyServiceInterface;
use App\Response\BookResponse;

class BooksController extends AbstractController
{

    /**
    * @var MyServiceInterface
    */

    public function __construct(MyServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
    * @Route("/books", methods={"POST"})
    */
    public function storeAction(Request $request)
    {
        return BookResponse::fromArray([
            'title' => $request->get('title'),
            'author' => $request->get('author'),
            'enabled' => $request->get('enabled'),
            'message' => $this->service->getMessage(),
        ]);
    }
}
