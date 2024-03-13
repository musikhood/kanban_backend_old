<?php

namespace App\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    public function __construct(protected string $value) {}

    final public function value(): string
    {
        return $this->value;
    }

    final public function updateValue(): string
    {
        return $this->value;
    }
}