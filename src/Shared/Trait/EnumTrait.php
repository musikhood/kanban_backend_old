<?php

namespace App\Shared\Trait;

use BackedEnum;

trait EnumTrait
{
    public static function enumValues(): array
    {
        return array_map(static fn (BackedEnum $item): string|int => $item->value, self::cases());
    }

    public static function enumNames(): array
    {
        return array_map(static fn (BackedEnum $item): string => $item->name, self::cases());
    }
}