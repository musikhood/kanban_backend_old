<?php

namespace App\Account\Domain\Repository;


use App\Account\Domain\Entity\Account;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface AccountRepositoryInterface
{
    public function save(Account $user): void;
}