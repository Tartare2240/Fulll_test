<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Doctrine\ORM\Mapping as ORM;
use Fulll\Infra\VehicleWriteRepository;

#[ORM\Entity]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 20)]
    private string $plate;

    #[ORM\ManyToOne(targetEntity: Fleet::class, cascade: ['persist'])]
    private ?Fleet $fleet;

    #[ORM\Embedded(class: Location::class)]
    private ?Location $location;

    public function __construct(string $plate, ?Fleet $fleet = null, ?Location $location = null)
    {
        $this->plate = $plate;
        $this->fleet = $fleet;
        $this->location = $location;
    }

    public function getPlate(): string
    {
        return $this->plate;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setFleet(?Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function isLocation(Location $location): bool
    {
        if (null === $this->location) {
            return false;
        }

        return $location->getLat() === $this->location->getLat() && $location->getLng() === $this->location->getLng();
    }
}
