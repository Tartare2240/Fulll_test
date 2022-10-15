<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Fulll\App\Command\ParkCommand;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use Fulll\Domain\Location;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private ?Fleet $fleet = null;
    private ?Vehicle $vehicle = null;
    private ?Location $location = null;
    private ParkCommand $parkCommand;
    private ?\Exception $error;

    public function __construct()
    {
        $this->parkCommand = new ParkCommand();
    }

    /** @BeforeScenario */
    public function clearData(): void
    {
        $this->fleet = null;
        $this->location = null;
        $this->vehicle = null;
        $this->error = null;
    }

    /**
     * @Given /^my fleet$/
     */
    public function myFleet(): void
    {
        $this->fleet = new Fleet();
    }

    /**
     * @Given /^a vehicle$/
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Vehicle('My plate');
    }

    /**
     * @Given /^I have registered this vehicle into my fleet$/
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->fleet->addVehicle($this->vehicle);
    }

    /**
     * @Given /^a location$/
     */
    public function aLocation(): void
    {
        $this->location = new Location();
    }

    /**
     * @When /^I park my vehicle at this location$/
     */
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->parkCommand->__invoke($this->vehicle, $this->location);
    }

    /**
     * @Then /^the known location of my vehicle should verify this location$/
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        if ($this->vehicle->getLocation() !== $this->location) {
            throw new Exception('Vehicle location is not the right location');
        }
    }

    /**
     * @Given /^my vehicle has been parked into this location$/
     */
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->vehicle->setLocation($this->location);
    }

    /**
     * @When /^I try to park my vehicle at this location$/
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->parkCommand->__invoke($this->vehicle, $this->location);
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
            throw new Exception('No warning that this vehicle was already parked here triggered.');
        }
    }
}
