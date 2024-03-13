<?php

namespace App\User\Application\Dto;

readonly class FindUserResponseDto
{
    public function __construct(
        private string $id,
        private string $email,
        private array  $roles
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}