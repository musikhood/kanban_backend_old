<?php

namespace App\Board\Application\Model\Query;

use Symfony\Component\Validator\Constraints as Assert;
readonly class FindBoardQuery
{
    public function __construct(
        #[Assert\NotBlank]
        private string $boardId
    )
    {
    }

    public function getBoardId(): string
    {
        return $this->boardId;
    }
}