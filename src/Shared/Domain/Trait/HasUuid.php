<?php

namespace App\Shared\Domain\Trait;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait HasUuid
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $id = null;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    #[ORM\PrePersist]
    public function initializeUuid(): void
    {
        if (null === $this->id) {
            $this->id = Uuid::uuid4();
        }
    }
}