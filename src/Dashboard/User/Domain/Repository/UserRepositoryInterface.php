<?php

namespace App\Dashboard\User\Domain\Repository;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findOneByAccountId(AccountId $accountId): ?User;
}