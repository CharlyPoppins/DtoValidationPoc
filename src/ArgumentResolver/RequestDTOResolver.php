<?php

namespace App\ArgumentResolver;

use App\Dto\Request\RequestDTOInterface;
use App\Exception\InvalidSchemaException;
use Generator;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDTOResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (class_exists($argument->getType())) {
            $reflection = new ReflectionClass($argument->getType());
            if ($reflection->implementsInterface(RequestDTOInterface::class)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return Generator
     * @throws InvalidSchemaException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $class = $argument->getType();
        $dto   = new $class($request);

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $exception = new InvalidSchemaException();
            $exception->setViolations($errors);
            throw $exception;
        }

        yield $dto;
    }
}
