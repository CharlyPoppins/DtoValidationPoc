<?php

namespace App\EventSubscriber;

use App\Exception\InvalidSchemaException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $e = $event->getThrowable();
        if (!$e instanceof InvalidSchemaException) {
            return;
        }

        $exception = $e->getErrorDetails();

        $response = new JsonResponse($exception, $exception['code']);

        $event->setResponse($response);
    }
}
