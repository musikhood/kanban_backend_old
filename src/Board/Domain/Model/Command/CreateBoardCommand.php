<?php

namespace App\Board\Domain\Model\Command;

use App\Account\Domain\Entity\AccountId;
use App\Board\Domain\Entity\BoardName;
use App\Shared\Domain\Cqrs\CommandInterface;

readonly class CreateBoardCommand implements CommandInterface
{
    public function __construct(
        private BoardName $name,
        private AccountId $userId
    )
    {
    }

    public function getUserId(): AccountId
    {
        return $this->userId;
    }

    public function getName(): BoardName
    {
        return $this->name;
    }
}