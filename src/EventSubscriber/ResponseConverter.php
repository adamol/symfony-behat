<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Response\ResponseInterface;

class ResponseConverter implements EventSubscriberInterface
{

    /**
    * @var ValidatorInterface
    */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'convertResponse',
        );
    }

    public function convertResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response instanceof ResponseInterface) {
            $errors = $this->validator->validate($response);

            if (count($errors) > 0) {
                $response->setData(['error' => (string) $errors]);
            }
        }
    }
}
