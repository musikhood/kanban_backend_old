<?php

namespace App\Account\Application\Dto;

use App\Account\Domain\Entity\AccountId;

readonly class FindAccountResponseDto implements \JsonSerializable
{
    public function __construct(
        private AccountId $id,
        private string $email,
        private array  $roles
    )
    {
    }

    public function getId(): AccountId
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

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id->value(),
            'email' => $this->email,
            'roles' => $this->roles
        ];
    }
}