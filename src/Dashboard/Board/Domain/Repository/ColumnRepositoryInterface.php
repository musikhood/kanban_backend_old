<?php

namespace App\Dashboard\Board\Domain\Repository;

use App\Dashboard\Board\Domain\Entity\Column;

interface ColumnRepositoryInterface
{
    public function save(Column $column): void;
}