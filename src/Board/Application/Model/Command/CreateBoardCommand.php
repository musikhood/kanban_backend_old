<?php

namespace App\Board\Application\Model\Command;

use Symfony\Component\Validator\Constraints as Assert;
readonly class CreateBoardCommand
{
    public function __construct(
        #[Assert\NotBlank]
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}