<?php

namespace App\User\Application\Port;

use App\User\Application\Dto\CreateUserResponseDto;
use App\User\Application\Dto\FindUserResponseDto;
use App\User\Domain\Entity\User;
use SensitiveParameter;

interface UserServiceInterface
{
    public function createUser(string $name, array $roles, #[SensitiveParameter] string $password): CreateUserResponseDto;
    public function findUser(string $userId): FindUserResponseDto;
    public function findUserEntity(string $userId): User;

}