<?php

namespace App\Shared\Application\Exception;


use Exception;

abstract class CustomException extends Exception
{
    public function __construct()
    {
        parent::__construct($this->errorMessage(), $this->errorCode());
    }

    abstract public function errorCode(): string;

    abstract public function errorMessage(): string;
}