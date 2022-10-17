<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Fulll\Domain\Vehicle;

class VehicleReadRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /** @throws NoResultException */
    public function findOneByPlate(string $vehiclePlate): Vehicle
    {
        return $this->entityManager->createQueryBuilder()
            ->select('v')
            ->from(Vehicle::class, 'v')
            ->where('v.plate = :plate')
            ->setParameter('plate', $vehiclePlate)
            ->getQuery()->getSingleResult();
    }
}
