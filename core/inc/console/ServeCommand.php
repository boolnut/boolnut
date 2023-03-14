<?php
namespace Boolnut\Core\Inc\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command implements CommandInterface
{
    protected $commandName = "serve";
    protected $commandDescription = "Starts a local web server";

    protected $commandArgumentName = "port";
    protected $commandArgumentDescription = "Port to listen on";

    protected $commandOptionName = "h";
    protected $commandOptionDescription = "Host to listen on";

    public function configure()
    {
        $this->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription,
                8000
            )
            ->addOption(
                $this->commandOptionName,
                null,
                InputOption::VALUE_OPTIONAL,
                $this->commandOptionDescription,
                "localhost"
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument($this->commandArgumentName);
        $host = $input->getOption($this->commandOptionName);

        $output->writeln("Starting server on $host:$port");

        $command = "php -q -S $host:$port";
        $output->writeln("Running command: $command");

        passthru($command);
    }
}
