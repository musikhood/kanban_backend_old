<?php

namespace App\Shared\Infrastructure\DoctrineMappings;

use App\Shared\Domain\Entity\UserId;
use App\Shared\Infrastructure\DoctrineTypes\UuidType;

final class UserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserId::class;
    }
}