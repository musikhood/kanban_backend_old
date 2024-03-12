<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Board\Infrastructure\Repository\BoardRepository;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoardRepository::class)]
class Board extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $userId;

    public function __construct(BoardId $id)
    {
        $this->id = $id->getValue();
    }

    public function getId(): BoardId
    {
        return new BoardId($this->id);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUserId(): UserId
    {
        return new UserId($this->userId);
    }

    public function setUserId(UserId $userId): void
    {
        $this->userId = $userId->getValue();
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function create(
        BoardId $boardId,
        UserId $userId,
        string $name
    ): self {
        $board = new self($boardId);
        $board->setUserId($userId);
        $board->setName($name);

        $board->recordDomainEvent(new BoardCreatedEvent($name));

        return $board;
    }
}
