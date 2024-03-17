<?php

namespace App\Board\Domain\RepositoryPort;

use App\Board\Domain\Entity\Board;

interface BoardRepositoryInterface
{
    public function save(Board $board): void;
}