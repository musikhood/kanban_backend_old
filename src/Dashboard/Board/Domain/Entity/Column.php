<?php

namespace App\Dashboard\Board\Domain\Entity;

class Column
{
    public function __construct(
        private readonly ColumnId $id,
        private readonly Board    $board,
        private ColumnName        $name,
        private ColumnColor       $color
    )
    {
    }

    public function id(): ColumnId
    {
        return $this->id;
    }
    public function name(): ColumnName
    {
        return $this->name;
    }
    public function rename(ColumnName $name): void{
        $this->name = $name;
    }

    public function board(): Board
    {
        return $this->board;
    }

    public function color(): ColumnColor
    {
        return $this->color;
    }

    public function updateColor(ColumnColor $color): void
    {
        $this->color = $color;
    }
}