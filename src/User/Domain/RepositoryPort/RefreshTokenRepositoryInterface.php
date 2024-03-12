<?php

namespace App\User\Domain\RepositoryPort;

use App\User\Domain\Entity\RefreshToken;

interface RefreshTokenRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);
    public function save(RefreshToken $user): void;
}