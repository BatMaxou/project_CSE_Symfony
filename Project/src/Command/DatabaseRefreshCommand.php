<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:database:refresh'
)]
class DatabaseRefreshCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Refresh the database')
            ->setHelp('Drop the database and recreate it with the current schema')
            ->addOption('force', '-f', InputOption::VALUE_NONE, 'Allows to drop and updtate the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if (!$input->getOption('force')) {
            $io->text('Please run the operation with --force to execute');
            $io->caution('All data will be lost!');
            return Command::INVALID;
        }

        $drop = $this->getApplication()->find('doctrine:database:drop');
        $create = $this->getApplication()->find('doctrine:database:create');
        $schema = $this->getApplication()->find('doctrine:schema:update');

        if (!$drop || !$create || !$schema) {
            $io->error('Failure when executing the command');
            $io->text('Make sure you have access to the followings doctrine commands :');
            $io->listing([
                'doctrine:database:drop',
                'doctrine:database:create',
                'doctrine:schema:update'
            ]);
            return Command::FAILURE;
        }

        if ($drop->run($input, $output) !== 0) {
            $io->warning('Ignoring the drop database step');
        } else {
            $io->success('Succeded to drop database');
        }

        $inputCreate = new ArrayInput([]);

        if ($create->run($inputCreate, $output) !== 0) {
            $io->error('Failure when executing the command : doctrine:database:create');
            return Command::FAILURE;
        }
        $io->success('Succeded to create database');

        if ($schema->run($input, $output) !== 0) {
            $io->error('Failure when executing the command : doctrine:schema:update');
            return Command::FAILURE;
        }
        $io->success('Succeded to update the database schema');

        return Command::SUCCESS;
    }
}
