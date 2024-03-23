<?php

namespace App\Account\Infrastructure\Repository;

use App\Account\Domain\Entity\RefreshToken;
use App\Account\Domain\Repository\RefreshTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Gesdinet\JWTRefreshTokenBundle\Doctrine\RefreshTokenRepositoryInterface as JwtRefreshTokenRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
class RefreshTokenRepository extends ServiceEntityRepository implements RefreshTokenRepositoryInterface, JwtRefreshTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    public function findInvalid($datetime = null)
    {
        $datetime = (null === $datetime) ? new \DateTime() : $datetime;

        return $this->createQueryBuilder('u')
            ->where('u.valid < :datetime')
            ->setParameter(':datetime', $datetime)
            ->getQuery()
            ->getResult();
    }
}
