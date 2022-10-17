<?php

declare(strict_types=1);

namespace Fulll\Features\bootstrap;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\CreateVehicleCommand;
use Fulll\App\Command\ParkCommand;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use Fulll\Domain\Location;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private ?Fleet $fleet = null;
    private ?string $lat = null;
    private ?string $lng = null;
    private ?\Exception $error;
    private mixed $result = null;
    private ?string $plate = null;

    private ParkCommand $parkCommand;
    private CreateVehicleCommand $createVehicleCommand;
    private CreateFleetCommand $createFleetCommand;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ParkCommand $parkCommand,
        CreateVehicleCommand $createVehicleCommand,
        CreateFleetCommand $createFleetCommand,
        EntityManagerInterface $entityManager,
    ) {
        $this->parkCommand = $parkCommand;
        $this->createVehicleCommand = $createVehicleCommand;
        $this->createFleetCommand = $createFleetCommand;
        $this->entityManager = $entityManager;
    }

    /** @BeforeScenario */
    public function clearData(): void
    {
        $this->fleet = null;
        $this->lat = null;
        $this->lng = null;
        $this->plate = null;
        $this->error = null;
        $this->result = null;

        $rsm = new ResultSetMapping();
        $query = $this->entityManager->createNativeQuery('DELETE FROM vehicle', $rsm);
        $query->execute();
        $query = $this->entityManager->createNativeQuery('DELETE FROM fleet', $rsm);
        $query->execute();
    }

    /**
     * @Given /^my fleet$/
     */
    public function myFleet(): void
    {
        $this->fleet = $this->createFleetCommand->__invoke(1);
    }

    /**
     * @Given /^a vehicle$/
     */
    public function aVehicle(): void
    {
        $this->plate = 'myPlate';
    }

    /**
     * @Given /^I have registered this vehicle into my fleet$/
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->createVehicleCommand->__invoke($this->fleet->getId(), $this->plate);
    }

    /**
     * @Given /^a location$/
     */
    public function aLocation(): void
    {
        $this->lat = "48°52'N";
        $this->lng = "2°19'E";
    }

    /**
     * @When /^I park my vehicle at this location$/
     */
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->result = $this->parkCommand->__invoke($this->plate, $this->lat, $this->lng);
    }

    /**
     * @Then /^the known location of my vehicle should verify this location$/
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        if ($this->result->getLocation()->getLat() !== $this->lat || $this->result->getLocation()->getLng() !== $this->lng) {
            throw new \Exception('Vehicle location is not the right location');
        }
    }

    /**
     * @Given /^my vehicle has been parked into this location$/
     */
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->parkCommand->__invoke($this->plate, $this->lat, $this->lng);
    }

    /**
     * @When /^I try to park my vehicle at this location$/
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->result = $this->parkCommand->__invoke($this->plate, $this->lat, $this->lng);
        } catch (\LogicException $e) {
            $this->error = $e;
        }
    }

    /**
     * @Then /^I should be informed that my vehicle is already parked at this location$/
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if ($this->error === null || $this->error->getMessage() !== ParkCommand::ALREADY_PARKED_HERE_MESSAGE) {
            throw new \Exception('No warning that this vehicle was already parked here triggered.');
        }
    }
}
