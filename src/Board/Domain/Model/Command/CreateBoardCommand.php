<?php

namespace App\Board\Domain\Model\Command;

use App\Board\Domain\Entity\BoardName;
use App\Shared\Domain\Cqrs\CommandInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class CreateBoardCommand implements CommandInterface
{
    public function __construct(
        private BoardName $name,
        private UserId $userId
    )
    {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): BoardName
    {
        return $this->name;
    }
}