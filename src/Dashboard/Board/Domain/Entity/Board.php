<?php

namespace App\Dashboard\Board\Domain\Entity;

use App\Dashboard\Board\Domain\Entity\ValueObject\BoardId;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardName;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnId;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnName;
use App\Dashboard\Board\Domain\Event\BoardCreatedEvent;
use App\Dashboard\Board\Domain\Exception\ColumnNotFoundException;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Board extends AggregateRoot
{
    private Collection $columns;
    public function __construct(
        private readonly BoardId $id,
        private BoardName        $name,
        private UserId $userId
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

    public function getColumn(ColumnId $columnId): ?Column {
        /** @var Column $column */
        foreach ($this->columns() as $column){
            if($column->id()->value() === $columnId->value()){
                return $column;
            }
        }

        return null;
    }

    /**
     * @throws ColumnNotFoundException
     */
    public function changeColumn(ColumnId $columnId, ColumnName $columnName, ColumnColor $columnColor): Column{
        $column = $this->getColumn($columnId);

        if (!$column){
            throw new ColumnNotFoundException();
        }

        $column->rename($columnName);
        $column->updateColor($columnColor);

        return $column;
    }

    public static function create(
        BoardId   $boardId,
        UserId $userId,
        BoardName $name
    ): self {
        $board = new self($boardId, $name, $userId);

        $board->recordDomainEvent(new BoardCreatedEvent($name));

        return $board;
    }
}
