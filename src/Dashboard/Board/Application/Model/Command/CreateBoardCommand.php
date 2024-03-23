<?php

namespace App\Dashboard\Board\Application\Model\Command;

use App\Dashboard\Board\Domain\Entity\BoardName;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Application\Cqrs\CommandInterface;

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