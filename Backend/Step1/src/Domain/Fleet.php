<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{
    /** @var Vehicle[] */
    private array $vehicle = [];

    /** @param Vehicle[] $vehicles */
    public function __construct(array $vehicles = [])
    {
        foreach ($vehicles as $vehicle) {
            $this->addVehicle($vehicle);
        }
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicle[] = $vehicle;
    }
}
