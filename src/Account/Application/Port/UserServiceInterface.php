<?php

namespace App\User\Application\Port;

use App\Shared\Domain\ValueObject\UserId;
use App\User\Application\Dto\CreateUserResponseDto;
use App\User\Application\Dto\FindUserResponseDto;
use App\User\Domain\Entity\User;
use SensitiveParameter;

interface UserServiceInterface
{
    public function createUser(string $name, array $roles, #[SensitiveParameter] string $password): CreateUserResponseDto;
    public function findUser(UserId $userId): FindUserResponseDto;
    public function findUserEntity(UserId $userId): User;

}