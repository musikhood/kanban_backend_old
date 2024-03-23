<?php

namespace App\Dashboard\User\Infrastructure\Repository;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\User\Domain\Entity\User;
use App\Dashboard\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    public function save(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

    public function findOneByAccountId(AccountId $accountId): ?User
    {
        return $this->findOneBy([
            'accountId' => $accountId
        ]);
    }
}