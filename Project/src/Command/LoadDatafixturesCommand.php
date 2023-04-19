<?php

namespace App\Command;

use Symfony\Component\Yaml\Yaml;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Service\DatafixturesBuilder;
use App\Repository\ContactRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use App\Repository\ImageTicketingRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load:datafixtures',
)]
class LoadDatafixturesCommand extends Command
{
    private DatafixturesBuilder $builder;

    function __construct(
        DatafixturesBuilder $builder
    ) {
        parent::__construct();
        $this->builder = $builder;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Insert datafixtures')
            ->setHelp('Clear the database and insert the data provided into jeu_essai.yaml.')
            ->addOption('force', '-f', InputOption::VALUE_NONE, 'Allows to clear the database and to insert the datafixtures.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$input->getOption('force')) {
            $io->text('Please run the operation with --force to execute');
            $io->caution('All data will be lost!');
            return Command::INVALID;
        }
        $def = new InputDefinition();
        $def->addOption(new InputOption('force'));

        $refreshInput = new ArrayInput([], $def);
        $refreshInput->setOption('force', true);

        try {
            $refresh = $this->getApplication()->find('app:database:refresh');
            $refresh->execute($input, $output);
        } catch (\Throwable $th) {
            $io->error('Problem raise during the refresh of the database');
            return Command::FAILURE;
        }


        try {
            $yaml = Yaml::parseFile('./datafixtures/config.yaml');
        } catch (\Throwable $th) {
            $io->error('File "datafixtures/config.yaml" doesn\'t exist');
            return Command::FAILURE;
        }

        if (!$this->builder->build($yaml, $io)) {
            $io->error('Problem raise during the insertion in database');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
