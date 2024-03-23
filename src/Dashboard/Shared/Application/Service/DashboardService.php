<?php

namespace App\Dashboard\Shared\Application\Service;

use App\Account\Domain\Entity\AccountId;
use App\Account\Infrastructure\Security\AccountAdapter;
use App\Dashboard\User\Application\Dto\UserDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\SecurityBundle\Security;

readonly class DashboardService implements DashboardServiceInterface
{
    public function __construct(
        private Security $security,
        private QueryBusInterface $queryBus
    )
    {
    }

    public function findUser(): UserDto
    {
        /** @var AccountAdapter $userInterface */
        $userInterface = $this->security->getUser();

        $account = $userInterface->getAccount();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var UserDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        return $userDto;
    }
}