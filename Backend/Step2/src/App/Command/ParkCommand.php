<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;
use Fulll\Infra\VehicleReadRepository;
use Fulll\Infra\VehicleWriteRepository;

class ParkCommand
{
    public const ALREADY_PARKED_HERE_MESSAGE = 'The vehicle is already at this location';

    private VehicleWriteRepository $vehicleWriteRepository;
    private VehicleReadRepository $vehicleReadRepository;

    public function __construct(
        VehicleWriteRepository $vehicleWriteRepository,
        VehicleReadRepository $vehicleReadRepository,
    ) {
        $this->vehicleWriteRepository = $vehicleWriteRepository;
        $this->vehicleReadRepository = $vehicleReadRepository;
    }

    public function __invoke(string $vehiclePlate, string $lat, string $lng): Vehicle
    {
        $vehicle = $this->vehicleReadRepository->findOneByPlate($vehiclePlate);
        $location = new Location($lat, $lng);

        if ($vehicle->isLocation($location)) {
            throw new \LogicException(self::ALREADY_PARKED_HERE_MESSAGE);
        }

        $vehicle->setLocation($location);
        $this->vehicleWriteRepository->save($vehicle);

        return $vehicle;
    }
}
