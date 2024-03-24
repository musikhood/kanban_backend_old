<?php

namespace App\Dashboard\Board\Domain\Entity\ValueObject;

use App\Shared\Domain\Entity\ValueObject\StringValueObject;

class ColumnColor extends StringValueObject
{
    public function hexToRgb(): string{
        list($r, $g, $b) = sscanf($this->value, "#%02x%02x%02x");
        return "$r, $g, $b";
    }
}