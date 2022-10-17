<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Location
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lng = null;

    public function __construct(string $lat, string $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }
}
