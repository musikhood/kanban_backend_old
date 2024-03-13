<?php

namespace App\Board\Domain\Entity;

use JsonSerializable;

class Column implements JsonSerializable
{
    public function __construct(
        private readonly string $id,
        private readonly Board  $board,
        private ColumnName      $name
    )
    {
    }

    public function id(): ColumnId
    {
        return new ColumnId($this->id);
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->uuid(),
            'name' => $this->name()->value(),
        ];
    }
}