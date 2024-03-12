<?php

namespace App\User\Domain\Entity;

use App\Shared\Aggregate\AggregateRoot;
use App\Shared\ValueObject\UserId;
use App\User\Domain\Event\UserCreatedEvent;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $id;

    private string $email;
    private array $roles = [];

    private string $password;

    public function __construct(UserId $userId)
    {
        $this->id = $userId->getValue();
    }

    public function getId(): UserId
    {
        return new UserId($this->id);
    }

    public function getEmail(): UserEmail
    {
        return new UserEmail($this->email);
    }

    public function setEmail(UserEmail $email): void
    {
        $this->email = $email->getValue();
    }
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function registerUser(UserEmail $email, array $roles): self
    {
        $userId = new UserId(Uuid::uuid4()->toString());
        $user = new self($userId);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->recordDomainEvent(new UserCreatedEvent($email));
        // Nie tworzymy tutaj hasła, bo trzeba będzie je zahashować.
        // Nie możemy zrobić tego w tym miejscu, bo musimy wstrzyknąć serwis do hashowania

        return $user;
    }
}
