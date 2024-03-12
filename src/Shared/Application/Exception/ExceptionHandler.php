<?php

namespace App\Shared\Application\Exception;

use App\Shared\Utils;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function Lambdish\Phunctional\get;

class ExceptionHandler
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_CONFLICT;
    private array $exceptions = [
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
    ];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): int
    {
        $statusCode = Utils::get($exceptionClass, $this->exceptions, self::DEFAULT_STATUS_CODE);

        if ($statusCode === null) {
            throw new InvalidArgumentException("There are no status code mapping for <$exceptionClass>");
        }

        return $statusCode;
    }
}