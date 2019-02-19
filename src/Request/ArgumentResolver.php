<?php

namespace App\Request;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpFoundation\Request;

class ArgumentResolver implements ArgumentValueResolverInterface
{

    /**
    * @var ValidatorInterface
    */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return null !== $argument->getType() &&
            is_subclass_of($argument->getType(), RequestInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $class = $argument->getType();

        $instance = $class::fromRequest($request);

        $errors = $this->validator->validate($instance);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        yield $instance;
    }
}
