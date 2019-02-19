<?php

namespace App\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookResponse extends JsonResponse implements ResponseInterface
{

    /**
    * @var string
    * @Assert\NotBlank
    */
    private $title;

    /**
    * @var string
    * @Assert\NotBlank
    */
    private $author;

    /**
    * @var bool
    * @Assert\NotBlank
    */
    private $enabled;

    /**
    * @var string
    * @Assert\NotBlank
    */
    private $message;

    public static function fromArray(array $data, int $statusCode = 201): self
    {
        $instance = new self($data, $statusCode);

        $instance->title = $data['title'];
        $instance->author = $data['author'];
        $instance->enabled = $data['enabled'];
        $instance->message = $data['message'];

        return $instance;
    }
}
