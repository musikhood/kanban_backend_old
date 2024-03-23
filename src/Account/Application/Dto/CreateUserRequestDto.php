<?php

namespace App\Account\Application\Dto;

use SensitiveParameter;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        private string $email,

        #[Assert\NotBlank]
        private array $roles,

        #[SensitiveParameter]
        #[Assert\NotBlank]
        private string $password
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}