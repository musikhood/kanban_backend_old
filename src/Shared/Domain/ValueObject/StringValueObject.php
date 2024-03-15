<?php

namespace App\Shared\Domain\ValueObject;
use Doctrine\ORM\Mapping as ORM;

abstract class StringValueObject
{
    public function __construct(
        #[ORM\Column(type: 'string')]
        protected string $value
    ) {
    }

    final public function value(): string
    {
        return $this->value;
    }

}