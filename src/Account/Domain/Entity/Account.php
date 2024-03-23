<?php

namespace App\Account\Domain\Entity;

use App\Account\Domain\Event\AccountCreatedEvent;
use App\Account\Infrastructure\Security\AccountAdapter;
use App\Shared\Domain\Aggregate\AggregateRoot;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class Account extends AggregateRoot
{
    private string $password;
    public function __construct(
        private readonly AccountId $id,
        private string             $email,
        private array              $roles = []
    )
    {
    }
    public function id(): AccountId
    {
        return $this->id;
    }
    public function email(): string
    {
        return $this->email;
    }
    public function updateEmail(string $email): void
    {
        $this->email = $email;
    }
    public function roles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function updateRoles(array $roles): void
    {
        $this->roles = $roles;
    }
    public function password(): string
    {
        return $this->password;
    }
    public function updatePassword(string $password): void
    {
        $this->password = $password;
    }
    public static function registerAccount(AccountId $id, string $email, string $password, array $roles): self
    {
        $passwordHasherFactory = new PasswordHasherFactory([
            // auto hasher with default options for the User class (and children)
            Account::class => ['algorithm' => 'auto'],

            // auto hasher with custom options for all PasswordAuthenticatedUserInterface instances
            PasswordAuthenticatedUserInterface::class => [
                'algorithm' => 'auto',
                'cost' => 15,
            ],
        ]);
        $hasher = new UserPasswordHasher($passwordHasherFactory);

        $account = new self($id, $email, $roles);

        $hashedPassword = $hasher->hashPassword(
            new AccountAdapter($account),
            $password
        );
        $account->updatePassword($hashedPassword);

        $account->recordDomainEvent(new AccountCreatedEvent($id));

        return $account;
    }
}
