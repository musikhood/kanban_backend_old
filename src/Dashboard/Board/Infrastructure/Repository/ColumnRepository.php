<?php

namespace App\Dashboard\Board\Infrastructure\Repository;

use App\Dashboard\Board\Domain\Entity\Column;
use App\Dashboard\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ColumnRepository extends ServiceEntityRepository implements ColumnRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Column::class);
    }

    public function save(Column $column): void
    {
        $em = $this->getEntityManager();
        $em->persist($column);
        $em->flush();
    }
}
