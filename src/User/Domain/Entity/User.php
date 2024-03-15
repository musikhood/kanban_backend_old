<?php

namespace App\User\Domain\Entity;

use App\Board\Domain\Entity\Board;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Trait\HasUuid;
use App\User\Domain\Event\UserCreatedEvent;
use App\User\Infrastructure\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    use HasUuid;
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Board::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $boards;

    public function __construct(
        #[ORM\Column(length: 180)]
        private ?string $email = null,

        #[ORM\Column]
        private array $roles = []
    ){
        $this->boards = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public static function registerUser(string $email, string $password, array $roles): self
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

        $user = new self($email, $roles);

        $hashedPassword = $hasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);

        $user->recordDomainEvent(new UserCreatedEvent($email));
        // Nie tworzymy tutaj hasła, bo trzeba będzie je zahashować.
        // Nie możemy zrobić tego w tym miejscu, bo musimy wstrzyknąć serwis do hashowania

        return $user;
    }

    /**
     * @return Collection<int, Board>
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function addBoard(Board $board): static
    {
        if (!$this->boards->contains($board)) {
            $this->boards->add($board);
            $board->setUser($this);
        }

        return $this;
    }

    public function removeBoard(Board $board): static
    {
        if ($this->boards->removeElement($board)) {
            // set the owning side to null (unless already changed)
            if ($board->getUser() === $this) {
                $board->setUser(null);
            }
        }

        return $this;
    }
}
