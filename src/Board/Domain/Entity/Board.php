<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Board\Domain\Event\ColumnCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Board extends AggregateRoot
{
    private Collection $columns;
    public function __construct(
        private readonly BoardId $id,
        private BoardName        $name,
        private UserId           $userId
    )
    {
        $this->columns = new ArrayCollection();
    }

    public function id(): BoardId
    {
        return $this->id;
    }

    public function name(): BoardName
    {
        return $this->name;
    }

    public function rename(BoardName $name): void
    {
        $this->name = $name;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function updateUser(UserId $userId): void
    {
        $this->userId = $userId;
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
            $columnId,
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
        $board = new self($boardId, $name, $userId);

        $board->recordDomainEvent(new BoardCreatedEvent($name));

        return $board;
    }
}
