<?php

namespace App\Dashboard\Board\Application\Dto;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardId;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardName;
use App\Dashboard\User\Domain\Entity\UserId;

readonly class BoardDto implements \JsonSerializable
{
    public function __construct(
        private BoardId $id,
        private UserId $userId,
        private BoardName $boardName,
        private array $columns
    )
    {
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function id(): BoardId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function boardName(): BoardName
    {
        return $this->boardName;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id'=>$this->id->value(),
            'userId'=>$this->userId->value(),
            'boardName'=>$this->boardName->value(),
            'columns' => $this->columns
        ];
    }
}