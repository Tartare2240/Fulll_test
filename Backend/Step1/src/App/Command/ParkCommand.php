<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;

class ParkCommand
{
    public const ALREADY_PARKED_HERE_MESSAGE = 'The vehicle is already at this location';

    public function __invoke(Vehicle $vehicle, Location $location): void
    {
        if ($location === $vehicle->getLocation()) {
            throw new \LogicException(self::ALREADY_PARKED_HERE_MESSAGE);
        }

        $vehicle->setLocation($location);
    }
}
