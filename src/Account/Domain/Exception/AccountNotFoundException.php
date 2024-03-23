<?php

namespace App\Account\Domain\Exception;

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
        return 'Account Not Found';
    }
}