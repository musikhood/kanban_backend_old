<?php

namespace App\User\Domain\Enum;

use App\Shared\Trait\EnumTrait;

enum RoleType: string
{
    use EnumTrait;

    case USER = "ROLE_USER";
    case ADMIN = "ROLE_ADMIN";
}
