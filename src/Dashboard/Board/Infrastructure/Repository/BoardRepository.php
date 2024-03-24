<?php

namespace App\Dashboard\Board\Infrastructure\Repository;

use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardId;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Dashboard\User\Domain\Entity\UserId;
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

    public function findByUserId(UserId $userId): array
    {
        return $this->findBy([
            'userId' => $userId,
        ]);
    }

    public function findOneById(BoardId $boardId): ?Board
    {
        return $this->findOneBy([
            'id' => $boardId,
        ]);
    }
}
