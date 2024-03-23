<?php

namespace App\Dashboard\Board\Infrastructure\DoctrineMappings;

use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Shared\Infrastructure\DoctrineMappings\UuidType;

class ColumnIdType extends UuidType
{

    protected function typeClassName(): string
    {
        return ColumnId::class;
    }
}