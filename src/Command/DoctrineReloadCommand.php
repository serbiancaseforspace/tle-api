<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class DoctrineReloadCommand extends Command
{
    protected static $defaultName = 'doctrine:reload';

    private static $choices = [
        'y' => 'Yes',
        'n' => 'No',
    ];

    private static $envs = [
        'dev',
        'test',
    ];

    private $env;

    public function __construct($env)
    {
        parent::__construct();
        $this->env = $env;
    }

    protected function configure(): void
    {
        $this->setDescription('Purge database, execute migrations and load fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion('All data will be lost. Do you wish to continue?', self::$choices, false);

        if (!in_array($this->env, self::$envs, true)) {
            $io->warning('This is intended only for use in dev environment.');

            return 1;
        }

        $application = $this->getApplication();

        if ($application === null) {
            return 1;
        }

        if ($input->getOption('no-interaction') || $helper->ask($input, $output, $question) === 'y') {
            $application->setAutoExit(false);

            $io->writeln('Drop database');
            $options = ['command' => 'doctrine:database:drop', '--force' => true];
            $application->run(new ArrayInput($options));

            $io->writeln('Create database');
            $options = ['command' => 'doctrine:database:create', '--if-not-exists' => true];
            $application->run(new ArrayInput($options));

            $io->writeln('Execute migrations');
            $options = ['command' => 'doctrine:migration:migrate', '--no-interaction' => true];
            $application->run(new ArrayInput($options));

            $io->writeln('Load fixtures');
            $options = ['command' => 'doctrine:fixtures:load', '--no-interaction' => true];
            $application->run(new ArrayInput($options));
        }

        return 0;
    }
}
