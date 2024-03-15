<?php

namespace App\Board\Domain\Entity;

use App\Board\Infrastructure\Repository\ColumnRepository;
use App\Shared\Domain\Trait\HasUuid;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
#[ORM\Table(name: 'board_column')]
#[ORM\Entity(repositoryClass: ColumnRepository::class)]
class Column implements JsonSerializable
{
    use HasUuid;

    #[ORM\ManyToOne(inversedBy: 'columns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Board $board = null;

    #[ORM\Embedded(class: ColumnName::class, columnPrefix: false)]
    private ?ColumnName $columnName = null;

    public function getColumnName(): ?ColumnName
    {
        return $this->columnName;
    }

    public function setColumnName(?ColumnName $columnName): static
    {
        $this->columnName = $columnName;

        return $this;
    }

    public function getBoard(): ?Board
    {
        return $this->board;
    }

    public function setBoard(?Board $board): static
    {
        $this->board = $board;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getColumnName()->value(),
        ];
    }
}
