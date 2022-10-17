<?php

declare(strict_types=1);

namespace Fulll\CLI;

use Symfony\Component\Console\Attribute\AsCommand;
use Fulll\App\Command\CreateFleetCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create',
    description: 'Creates a new fleet.'
)]
class CreateFleetCLI extends Command
{
    private CreateFleetCommand $createFleetCommand;

    public function __construct(CreateFleetCommand $createFleetCommand, string $name = null)
    {
        $this->createFleetCommand = $createFleetCommand;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('userId');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = $input->getArgument('userId');
        $fleet = $this->createFleetCommand->__invoke((int)$userId);

        $output->writeln(sprintf('Fleet created with id %d', $fleet->getId()));

        return self::SUCCESS;
    }
}
