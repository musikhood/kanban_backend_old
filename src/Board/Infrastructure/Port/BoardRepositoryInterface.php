<?php

namespace App\Board\Infrastructure\Port;

use App\Board\Domain\Entity\Board;

interface BoardRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);
    public function save(Board $board): void;
}