<?php

namespace App\User\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class FindUserRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private string $userId
    )
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}