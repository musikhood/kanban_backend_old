<?php

namespace App\User\Domain\RepositoryPort;

use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}