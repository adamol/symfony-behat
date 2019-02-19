<?php

namespace App\Controller;

use App\Request\StoreBookRequest;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function storeAction(StoreBookRequest $request)
    {
        return BookResponse::fromArray([
            'title' => $request->getTitle(),
            'author' => $request->getAuthor(),
            'enabled' => $request->isEnabled(),
            'message' => $this->service->getMessage(),
        ]);
    }
}
