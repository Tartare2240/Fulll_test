<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Fulll\Domain\Fleet;

class FleetReadRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /** @throws NoResultException */
    public function findOneById(int $fleetId): Fleet
    {
        return $this->entityManager->createQueryBuilder()
            ->select('f')
            ->from(Fleet::class, 'f')
            ->where('f.id = :id')
            ->setParameter('id', $fleetId)
            ->getQuery()->getSingleResult();
    }
}
