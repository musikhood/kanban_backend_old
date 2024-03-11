<?php

namespace App\User\Application\Exception;

use App\User\Application\Model\Command\CreateUserCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_CONFLICT)]
class UserAlreadyExistException extends \Exception
{
    public function __construct(
        private readonly CreateUserCommand $command
    )
    {
        parent::__construct('User Already Exist');
    }

    public function getCommand(): CreateUserCommand
    {
        return $this->command;
    }
}