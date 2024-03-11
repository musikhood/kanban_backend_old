<?php

namespace App\User\Application\Model\Command;
use SensitiveParameter;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserCommand
{
    public function __construct(
        #[Assert\Email(
            message: 'Mail {{ value }} jest nie poprawny.'
        )]
        private string $email,
        private array $roles,
        #[SensitiveParameter]
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