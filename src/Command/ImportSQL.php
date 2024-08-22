<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:import-sql')]
class ImportSQL extends Command
{
    private const DATA_DIR = '/data/application/migrations/data/';

    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (\is_dir(self::DATA_DIR) === false) {
            \var_dump('error');exit;
        }

        $files = \array_diff(
            \scandir(self::DATA_DIR), ['..', '.']
        );

        try {
            foreach ($files as $filename) {
                $rowsAffected = $this->connection->executeStatement(
                    \file_get_contents(self::DATA_DIR . $filename)
                );

                $output->writeln(
                    \sprintf(
                        'Processed file: %s, rows affected: %s.',
                        $filename,
                        $rowsAffected
                    )
                );
            }

        } catch (\Exception $e) {
            $output->writeln(
                \sprintf('Error, msg: %s', $e->getMessage())
            );

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
