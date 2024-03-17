<?php

namespace App\Board\Infrastructure\DoctrineMappings;

use App\Board\Domain\Entity\BoardId;
use App\Shared\Infrastructure\DoctrineMappings\UuidType;

class BoardIdType extends UuidType
{

    protected function typeClassName(): string
    {
        return BoardId::class;
    }
}