<?php

namespace App\Dashboard\Board\Application\Dto;

readonly class ColumnDto implements \JsonSerializable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $color,
        private string $colorRgb
    )
    {
    }

    public function colorRgb(): string
    {
        return $this->colorRgb;
    }

    public function color(): string
    {
        return $this->color;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => [
                'hex' => $this->color,
                'rgb' => $this->colorRgb
            ]
        ];
    }
}