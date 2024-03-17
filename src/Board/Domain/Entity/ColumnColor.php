<?php

namespace App\Board\Domain\Entity;

use App\Shared\Domain\ValueObject\StringValueObject;

class ColumnColor extends StringValueObject
{
    public function hexToRgb(): array{
        list($r, $g, $b) = sscanf($this->value, "#%02x%02x%02x");

        return [
            'r'=>$r,
            'g'=>$g,
            'b'=>$b
        ];
    }
}