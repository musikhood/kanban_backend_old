<?php

namespace App\User\Application\Port;

use App\User\Application\Dto\CreateUserResponseDto;
use SensitiveParameter;

interface UserServiceInterface
{
    public function createUser(string $name, array $roles, #[SensitiveParameter] string $password): CreateUserResponseDto;
}