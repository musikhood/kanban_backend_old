<?php

namespace App\Dashboard\User\Domain\Repository;

use App\Dashboard\User\Domain\Entity\User;

/**
* @method User|null findOneBy(array $criteria, array $orderBy = null)
*/
interface UserRepositoryInterface
{
    public function save(User $user): void;
}