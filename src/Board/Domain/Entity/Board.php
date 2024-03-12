<?php

namespace App\Board\Domain\Entity;

use App\Board\Domain\Event\BoardCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Entity\UserId;

class Board extends AggregateRoot
{
    public function __construct(
        private readonly BoardId $id,
        private BoardName        $name,
        private UserId           $userId
    )
    {
    }

    public function getId(): BoardId
    {
        return $this->id;
    }

    public function getName(): BoardName
    {
        return $this->name;
    }

    public function setName(BoardName $name): void
    {
        $this->name = $name;
    }

    public function getUser(): UserId
    {
        return $this->userId;
    }

    public function setUser(UserId $user): void
    {
        $this->userId = $user;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
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
