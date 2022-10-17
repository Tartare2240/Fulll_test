<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Doctrine\ORM\NoResultException;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;
use Fulll\Infra\FleetReadRepository;
use Fulll\Infra\VehicleWriteRepository;

class CreateVehicleCommand
{
    private VehicleWriteRepository $vehicleWriteRepository;
    private FleetReadRepository $fleetReadRepository;

    public function __construct(
        VehicleWriteRepository $vehicleWriteRepository,
        FleetReadRepository $fleetReadRepository,
    ) {
        $this->vehicleWriteRepository = $vehicleWriteRepository;
        $this->fleetReadRepository = $fleetReadRepository;
    }

    /** @throws NoResultException */
    public function __invoke(int $fleetId, string $plate): Vehicle
    {
        $fleet = $this->fleetReadRepository->findOneById($fleetId);
        $vehicle = new Vehicle($plate, $fleet);
        $this->vehicleWriteRepository->save($vehicle);

        return $vehicle;
    }
}
