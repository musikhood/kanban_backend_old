<?php

namespace App\Account\Domain\Repository;


use App\Account\Domain\Entity\Account;
use App\Account\Domain\Entity\AccountId;

interface AccountRepositoryInterface
{
    public function save(Account $user): void;
    public function findOneById(AccountId $accountId): ?Account;
    public function findOneByEmail(string $email): ?Account;
}