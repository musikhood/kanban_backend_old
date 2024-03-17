<?php

namespace App\Board\Application\Model\Command;

use App\Board\Domain\Entity\BoardName;
use App\Shared\Application\Cqrs\CommandInterface;
use App\Shared\Domain\ValueObject\UserId;
use App\User\Domain\Entity\User;

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