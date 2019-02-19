<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class StoreBookRequest implements RequestInterface
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

    public static function fromRequest(Request $request)
    {
        $instance = new self();

        $instance->title = $request->get('title');
        $instance->author = $request->get('author');
        $instance->enabled = $request->get('enabled');

        return $instance;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
