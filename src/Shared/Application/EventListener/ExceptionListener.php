<?php

namespace App\Shared\Application\EventListener;

use App\Shared\Application\Exception\CustomException;
use App\Shared\Application\Exception\ExceptionHandler;
use App\Shared\Utils;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

readonly class ExceptionListener
{

    public function __construct(
        private ExceptionHandler $exceptionHandler
    )
    {
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if(
            (
                $exception instanceof HttpException ||
                $exception instanceof HandlerFailedException
            ) &&
            $exception->getPrevious()
        ){
            $exception = $exception->getPrevious();
        }

        $event->setResponse(
            new JsonResponse(
                [
                    'code' => $this->exceptionCodeFor($exception),
                    'message' => $exception->getMessage(),
                ],
                $this->exceptionHandler->statusCodeFor($exception::class)
            )
        );
    }

    private function exceptionCodeFor(Throwable $error): string
    {
        return $error instanceof CustomException
            ? $error->errorCode()
            : Utils::toSnakeCase($this->extractClassName($error));
    }

    private function extractClassName(object $object): string
    {
        $reflect = new ReflectionClass($object);

        return $reflect->getShortName();
    }
}