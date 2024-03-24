<?php

namespace App\Dashboard\Board\Domain\Entity;

use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnId;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnName;

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

    public static function createColumn(
        Board $board,
        ColumnId $columnId,
        ColumnName $columnName,
        ColumnColor $columnColor
    ): Column {
        return new Column(
            $columnId,
            $board,
            $columnName,
            $columnColor
        );
    }
}