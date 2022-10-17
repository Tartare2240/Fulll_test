<?php

declare(strict_types=1);

namespace Fulll\CLI;

use Doctrine\ORM\NoResultException;
use Fulll\App\Command\CreateVehicleCommand;
use Fulll\App\Command\ParkCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:park-vehicle',
    description: 'Park a vehicle.'
)]
class ParkVehicleCLI extends Command
{
    private ParkCommand $parkCommand;

    public function __construct(ParkCommand $parkCommand, string $name = null)
    {
        $this->parkCommand = $parkCommand;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('fleetId')
            ->addArgument('vehiclePlate')
            ->addArgument('lat')
            ->addArgument('lng')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fleetId = $input->getArgument('fleetId');
        $vehiclePlate = $input->getArgument('vehiclePlate');
        $lat = $input->getArgument('lat');
        $lng = $input->getArgument('lng');

        try {
            $this->parkCommand->__invoke($vehiclePlate, $lat, $lng);
        } catch (\LogicException $e) {
            $output->writeln($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
