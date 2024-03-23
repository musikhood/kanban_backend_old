<?php

namespace App\Dashboard\Board\Domain\Entity;

use App\Shared\Domain\ValueObject\StringValueObject;

class ColumnColor extends StringValueObject
{
    public function hexToRgb(): string{
        list($r, $g, $b) = sscanf($this->value, "#%02x%02x%02x");
        return "$r, $g, $b";
    }
}