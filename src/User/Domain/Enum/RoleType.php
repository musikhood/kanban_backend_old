<?php

namespace App\User\Domain\Enum;

use App\Shared\Domain\Trait\EnumTrait;

enum RoleType: string
{
    use EnumTrait;

    case USER = "ROLE_USER";
    case ADMIN = "ROLE_ADMIN";
}
