<?php

namespace App\Board\Domain\Model\Command;

use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\ColumnColor;
use App\Board\Domain\Entity\ColumnName;
use App\Shared\Domain\Cqrs\CommandInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class CreateColumnCommand implements CommandInterface
{
    public function __construct(
        private UserId $userId,
        private BoardId $boardId,
        private ColumnName $name,
        private ColumnColor $color
    )
    {
    }

    public function getColor(): ColumnColor
    {
        return $this->color;
    }


    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }

    public function getName(): ColumnName
    {
        return $this->name;
    }
}