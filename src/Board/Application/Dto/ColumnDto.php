<?php

namespace App\Board\Application\Dto;

readonly class ColumnDto
{
    public function __construct(
        private string $id,
        private string $name,
        private string $color,
        private string $colorRgb
    )
    {
    }

    public function getColorRgb(): string
    {
        return $this->colorRgb;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}