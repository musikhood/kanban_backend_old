<?php

namespace App\Account\Application\Exception;

use App\Shared\Domain\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_NOT_FOUND)]
class AccountNotFoundException extends CustomException
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