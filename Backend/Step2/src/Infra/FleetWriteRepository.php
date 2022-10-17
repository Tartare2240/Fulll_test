<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Doctrine\ORM\EntityManagerInterface;
use Fulll\Domain\Fleet;

class FleetWriteRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function save(Fleet $fleet): void
    {
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();
    }
}
