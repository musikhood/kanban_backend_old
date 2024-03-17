<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\UserId;
use App\User\Domain\Event\UserCreatedEvent;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $password;
    public function __construct(
        private readonly UserId $id,
        private string          $email,
        private array           $roles = []
    )
    {
    }
    public function id(): UserId
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
    public function getUserIdentifier(): string
    {
        return $this->email();
    }
    public function getRoles(): array
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
    public function getPassword(): string
    {
        return $this->password;
    }
    public function updatePassword(string $password): void
    {
        $this->password = $password;
    }
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public static function registerUser(UserId $userId, string $email, string $password, array $roles): self
    {
        $passwordHasherFactory = new PasswordHasherFactory([
            // auto hasher with default options for the User class (and children)
            User::class => ['algorithm' => 'auto'],

            // auto hasher with custom options for all PasswordAuthenticatedUserInterface instances
            PasswordAuthenticatedUserInterface::class => [
                'algorithm' => 'auto',
                'cost' => 15,
            ],
        ]);
        $hasher = new UserPasswordHasher($passwordHasherFactory);

        $user = new self($userId, $email, $roles);

        $hashedPassword = $hasher->hashPassword(
            $user,
            $password
        );
        $user->updatePassword($hashedPassword);

        $user->recordDomainEvent(new UserCreatedEvent($email));
        // Nie tworzymy tutaj hasła, bo trzeba będzie je zahashować.
        // Nie możemy zrobić tego w tym miejscu, bo musimy wstrzyknąć serwis do hashowania

        return $user;
    }
}
