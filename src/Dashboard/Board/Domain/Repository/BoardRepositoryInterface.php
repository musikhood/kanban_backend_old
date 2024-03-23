<?php

namespace App\Dashboard\Board\Domain\Repository;

use App\Dashboard\Board\Domain\Entity\Board;

/**
 * @method Board|null find($id, $lockMode = null, $lockVersion = null)
 * @method Board|null findOneBy(array $criteria, array $orderBy = null)
 * @method Board[]    findAll()
 * @method Board[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface BoardRepositoryInterface
{
    public function save(Board $board): void;
}