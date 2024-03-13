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

    public function user(): UserId
    {
        return $this->userId;
    }

    public function updateUser(UserId $user): void
    {
        $this->userId = $user;
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
