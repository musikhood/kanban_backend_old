<?php

namespace App\Dashboard\User\Domain\Exception;

use App\Shared\Domain\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_NOT_FOUND)]

class UserNotFoundException extends CustomException
{

    public function errorCode(): string
    {
       return Response::HTTP_NOT_FOUND;
    }

    public function errorMessage(): string
    {
        return 'User Not Found';
    }
}