<?php

namespace App\Dashboard\Shared\Application\Service;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;
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

    public function findUser(): FindUserResponseDto
    {
        $account = $this->security->getUser()->getAggregate();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var FindUserResponseDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        return $userDto;
    }
}