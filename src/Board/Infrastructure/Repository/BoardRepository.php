<?php

namespace App\Board\Infrastructure\Repository;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BoardRepository extends ServiceEntityRepository implements BoardRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Board::class);
    }

    public function save(Board $board): void
    {
        $em = $this->getEntityManager();
        $em->persist($board);
        $em->flush();
    }
}
