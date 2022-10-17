<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Fleet;
use Fulll\Infra\FleetWriteRepository;

class CreateFleetCommand
{
    private FleetWriteRepository $fleetWriteRepository;

    public function __construct(FleetWriteRepository $fleetWriteRepository) {
        $this->fleetWriteRepository = $fleetWriteRepository;
    }

    public function __invoke(int $userId): Fleet
    {
        $fleet = new Fleet($userId);
        $this->fleetWriteRepository->save($fleet);

        return $fleet;
    }
}
