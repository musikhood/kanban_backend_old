<?php

namespace App\User\Infrastructure\Port;

use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);
    public function findAll();
    public function save(User $user): void;
}