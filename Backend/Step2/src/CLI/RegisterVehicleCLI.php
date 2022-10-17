<?php

declare(strict_types=1);

namespace Fulll\CLI;

use Doctrine\ORM\NoResultException;
use Fulll\App\Command\CreateVehicleCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:register-vehicle',
    description: 'Creates a new vehicle.'
)]
class RegisterVehicleCLI extends Command
{
    private CreateVehicleCommand $createVehicleCommand;

    public function __construct(CreateVehicleCommand $createVehicleCommand, string $name = null)
    {
        $this->createVehicleCommand = $createVehicleCommand;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('fleetId')
            ->addArgument('vehiclePlate')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fleetId = $input->getArgument('fleetId');
        $vehiclePlate = $input->getArgument('vehiclePlate');

        try {
            $vehicle = $this->createVehicleCommand->__invoke((int)$fleetId, $vehiclePlate);
        } catch (NoResultException $e) {
            $output->writeln('No fleet with this ID exist.');

            return self::FAILURE;
        }

        $output->writeln(sprintf('Vehicle created with id %d', $vehicle->getId()));

        return self::SUCCESS;
    }
}
