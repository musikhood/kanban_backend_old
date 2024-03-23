<?php

namespace App\Dashboard\User\Application\Dto;

use App\Dashboard\User\Domain\Entity\UserId;

readonly class UserDto implements \JsonSerializable
{
    public function __construct(
        private UserId $id
    )
    {
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id'=> $this->id->value()
        ];
    }
}