<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\ValueObject\UserId;
class Board extends AggregateRoot
{
    private string $id;
    private string $name;
    private string $user;

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

    public function getUser(): UserId
    {
        return new UserId($this->user);
    }

    public function setUser(UserId $user): void
    {
        $this->user = $user->getValue();
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
        $board->setUser($userId);
        $board->setName($name);

        $board->recordDomainEvent(new BoardCreatedEvent($name));

        return $board;
    }
}
