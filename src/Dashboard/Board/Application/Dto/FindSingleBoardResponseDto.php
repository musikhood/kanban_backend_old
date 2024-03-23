<?php

namespace App\Dashboard\Board\Application\Dto;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\Dashboard\User\Domain\Entity\UserId;

readonly class FindSingleBoardResponseDto implements \JsonSerializable
{
    public function __construct(
        private BoardId $id,
        private UserId $userId,
        private BoardName $boardName,
    )
    {
    }

    public function getId(): BoardId
    {
        return $this->id;
    }

    public function getUser(): UserId
    {
        return $this->userId;
    }

    public function getBoardName(): BoardName
    {
        return $this->boardName;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id'=>$this->id->value(),
            'userId'=>$this->userId->value(),
            'boardName'=>$this->boardName->value()
        ];
    }
}