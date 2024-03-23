<?php

namespace App\Account\Infrastructure\DoctrineMappings;

use App\Shared\Domain\ValueObject\UserId;
use App\Shared\Infrastructure\DoctrineMappings\UuidType;

class UserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserId::class;
    }
}