<?php

namespace App\Board\Domain\RepositoryPort;

use App\Board\Domain\Entity\Column;

interface ColumnRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);

    public function save(Column $column): void;
}