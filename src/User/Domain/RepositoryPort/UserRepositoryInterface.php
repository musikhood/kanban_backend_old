<?php

namespace App\User\Domain\RepositoryPort;

use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findBy(array $criteria, array $orderBy = null);
    public function findOneBy(array $criteria, array $orderBy = null);
    public function findAll();
    public function save(User $user): void;
}