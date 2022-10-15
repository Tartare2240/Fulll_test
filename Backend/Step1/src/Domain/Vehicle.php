<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Vehicle
{
    public string $plate;
    private ?Location $location;

    public function __construct(string $plate, ?Location $location = null)
    {
        $this->plate = $plate;
        $this->location = $location;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }
}
