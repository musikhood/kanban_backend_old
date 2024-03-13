<?php

namespace App\Shared\Application\Dto;

abstract readonly class AbstractCommandResponseDto
{

    public function __construct(protected string $message) {}

    final public function getMessage(): string
    {
        return $this->message;
    }
}