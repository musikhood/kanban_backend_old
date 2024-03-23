<?php

namespace App\Dashboard\Board\Domain\RepositoryPort;

use App\Dashboard\Board\Domain\Entity\Column;

interface ColumnRepositoryInterface
{
    public function save(Column $column): void;
}