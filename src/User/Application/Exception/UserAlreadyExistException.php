<?php

namespace App\User\Application\Exception;

use App\Shared\Application\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_CONFLICT)]
class UserAlreadyExistException extends CustomException
{
    public function errorCode(): string
    {
        return Response::HTTP_CONFLICT;
    }

    public function errorMessage(): string
    {
        return 'User Already Exist';
    }
}