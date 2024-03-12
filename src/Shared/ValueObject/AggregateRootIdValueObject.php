<?php

namespace App\Shared\ValueObject;

abstract class AggregateRootIdValueObject
{
    protected string $uuid;

    public function __construct(string $uuid)
    {
        if (!preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid)) {
            throw new \InvalidArgumentException('Not valid UUID');
        }

        $this->uuid = $uuid;
    }

    public function getValue(): string
    {
        return $this->uuid;
    }

}