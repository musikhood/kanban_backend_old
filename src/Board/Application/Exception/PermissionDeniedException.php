<?php

namespace App\Board\Application\Exception;

use App\Shared\Application\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_FORBIDDEN)]
class PermissionDeniedException extends CustomException
{

    public function errorCode(): string
    {
        return Response::HTTP_FORBIDDEN;
    }

    public function errorMessage(): string
    {
        return 'Permission Denied';
    }
}