<?php

namespace App\Account\Infrastructure\Security;

use App\Account\Domain\Entity\Account;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class AccountAdapter implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private Account $account
    )
    {
    }

    public function getRoles(): array
    {
        return $this->account->roles();
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->account->email();
    }

    public function getAggregate(): Account
    {
        return $this->account;
    }

    public function getPassword(): ?string
    {
        return $this->account->password();
    }
}