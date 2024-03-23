<?php

namespace App\Account\Infrastructure\DoctrineMappings;

use App\Account\Domain\Entity\AccountId;
use App\Shared\Infrastructure\DoctrineMappings\UuidType;

class AccountIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return AccountId::class;
    }
}