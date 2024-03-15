<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Board\Domain\Event\ColumnCreatedEvent;
use App\Board\Infrastructure\Repository\BoardRepository;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Trait\HasUuid;
use App\User\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Table(name: 'board')]
#[ORM\Entity(repositoryClass: BoardRepository::class)]
class Board extends AggregateRoot implements JsonSerializable
{
    use HasUuid;
    #[ORM\OneToMany(targetEntity: Column::class, mappedBy: 'board', orphanRemoval: true)]
    private Collection $columns;

    #[ORM\ManyToOne(inversedBy: 'boards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

     #[ORM\Embedded(class: BoardName::class, columnPrefix: false)]
    private ?BoardName $boardName = null;

    public function __construct()
    {
        $this->columns = new ArrayCollection();
    }

    public function getBoardName(): ?BoardName
    {
        return $this->boardName;
    }

    public function setBoardName(?BoardName $boardName): void
    {
        $this->boardName = $boardName;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public static function create(
        User      $user,
        BoardName $boardName
    ): self {
        $board = new self();
        $board->setUser($user);
        $board->setBoardName($boardName);

        $board->recordDomainEvent(new BoardCreatedEvent($boardName));

        return $board;
    }

    public static function createColumn(
        Board      $board,
        ColumnName $columnName
    ): Column {
        $column = new Column();
        $column->setBoard($board);
        $column->setColumnName($columnName);

        $board->recordDomainEvent(new ColumnCreatedEvent($columnName));

        return $column;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'userId' => $this->getUser()->getId(),
            'name' => $this->getBoardName()->value(),
            'columns' => $this->getColumns()
        ];
    }

    /**
     * @return Collection<int, Column>
     */
    public function getColumns(): Collection
    {
        return $this->columns;
    }

    public function addColumn(Column $column): static
    {
        if (!$this->columns->contains($column)) {
            $this->columns->add($column);
            $column->setBoard($this);
        }

        return $this;
    }

    public function removeColumn(Column $column): static
    {
        if ($this->columns->removeElement($column)) {
            // set the owning side to null (unless already changed)
            if ($column->getBoard() === $this) {
                $column->setBoard(null);
            }
        }

        return $this;
    }
}
