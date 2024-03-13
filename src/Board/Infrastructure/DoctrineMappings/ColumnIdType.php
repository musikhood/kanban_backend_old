<?php

namespace App\Board\Infrastructure\DoctrineMappings;

use App\Board\Domain\Entity\ColumnId;
use App\Shared\Infrastructure\DoctrineTypes\UuidType;

class ColumnIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ColumnId::class;
    }
}