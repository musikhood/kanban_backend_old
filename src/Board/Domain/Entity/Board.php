<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Board\Infrastructure\Repository\BoardRepository;
use App\Shared\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoardRepository::class)]
class Board extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function create(
        string $name
    ): self {
        $board = new self();
        $board->setName($name);

        $board->recordDomainEvent(new BoardCreatedEvent($name));

        return $board;
    }
}
