<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Board\Domain\Event\ColumnCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Entity\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;

class Board extends AggregateRoot implements JsonSerializable
{
    private Collection $columns;
    public function __construct(
        private readonly string $id,
        private BoardName        $name,
        private UserId           $userId
    )
    {
        $this->columns = new ArrayCollection();
    }

    public function id(): BoardId
    {
        return new BoardId($this->id);
    }

    public function name(): BoardName
    {
        return $this->name;
    }

    public function rename(BoardName $name): void
    {
        $this->name = $name;
    }

    public function user(): UserId
    {
        return $this->userId;
    }

    public function updateUser(UserId $user): void
    {
        $this->userId = $user;
    }

    public function columns(): Collection
    {
        return $this->columns;
    }

    public function addColumn(Column $column): void{
        $this->columns->add($column);
    }

    public static function createColumn(
        Board $board,
        ColumnId $columnId,
        ColumnName $name
    ): Column {
        $column = new Column(
            $columnId->uuid(),
            $board,
            $name
        );

        $board->recordDomainEvent(new ColumnCreatedEvent($name));

        return $column;
    }
    public static function create(
        BoardId $boardId,
        UserId $userId,
        BoardName $name
    ): self {
        $board = new self($boardId->uuid(), $name, $userId);

        $board->recordDomainEvent(new BoardCreatedEvent($name));

        return $board;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->uuid(),
            'userId' => $this->user()->uuid(),
            'name' => $this->name()->value(),
            'columns' => $this->columns()
        ];
    }
}
