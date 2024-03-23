<?php

namespace App\Account\Infrastructure\Security;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class AccountLoader implements  UserProviderInterface, UserLoaderInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository
    )
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return Account::class === $class || is_subclass_of($class, Account::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (null === ($account = $this->accountRepository->findOneBy(['email' => $identifier]))) {
            throw new BadCredentialsException(sprintf('No account found for "%s"', $account));
        }
        return new AccountAdapter($account);
    }
}