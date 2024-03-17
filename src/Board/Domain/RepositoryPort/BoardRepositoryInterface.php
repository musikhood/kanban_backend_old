<?php

namespace App\Board\Domain\RepositoryPort;

use App\Board\Domain\Entity\Board;

interface BoardRepositoryInterface
{
    public function findBy(array $criteria, array $orderBy = null);
    public function findOneBy(array $criteria, array $orderBy = null);
    public function save(Board $board): void;
}