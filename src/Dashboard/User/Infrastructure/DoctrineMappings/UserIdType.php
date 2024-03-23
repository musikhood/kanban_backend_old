<?php

namespace App\Dashboard\User\Infrastructure\DoctrineMappings;

use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Infrastructure\DoctrineMappings\UuidType;

class UserIdType extends UuidType
{

    protected function typeClassName(): string
    {
        return UserId::class;
    }
}