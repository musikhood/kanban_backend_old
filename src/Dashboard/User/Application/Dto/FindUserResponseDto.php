<?php

namespace App\Dashboard\User\Application\Dto;

use App\Dashboard\User\Domain\Entity\UserId;

readonly class FindUserResponseDto
{
    public function __construct(
        private UserId $id
    )
    {
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}