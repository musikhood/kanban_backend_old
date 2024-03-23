<?php

namespace App\Dashboard\Board\Infrastructure\DoctrineMappings;

use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Shared\Infrastructure\DoctrineMappings\UuidType;

class BoardIdType extends UuidType
{

    protected function typeClassName(): string
    {
        return BoardId::class;
    }
}