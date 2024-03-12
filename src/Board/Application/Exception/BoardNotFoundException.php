<?php

namespace App\Board\Application\Exception;

use App\Shared\Application\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_NOT_FOUND)]
class BoardNotFoundException extends CustomException
{
    public function errorCode(): string
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function errorMessage(): string
    {
        return 'Board Not Found';
    }
}