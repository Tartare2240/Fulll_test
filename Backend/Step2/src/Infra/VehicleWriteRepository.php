<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Doctrine\ORM\EntityManagerInterface;
use Fulll\Domain\Vehicle;

class VehicleWriteRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function save(Vehicle $vehicle): void
    {
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }
}
