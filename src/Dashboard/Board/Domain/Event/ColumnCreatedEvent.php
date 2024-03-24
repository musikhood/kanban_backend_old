<?php

namespace App\Dashboard\Board\Domain\Event;

use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnName;
use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ColumnCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly ColumnName $name,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getColumnName(): ColumnName
    {
        return $this->name;
    }

}