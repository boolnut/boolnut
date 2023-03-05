<?php

namespace Boolnut\Core\Inc\Console;

use Boolnut\Core\Inc\Helper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


Class ControllerCommand extends Command implements CommandInterface
{
    protected $commandName = 'make:controller';
    protected $commandDescription = "Creates a new controller";
    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Name of the controller";
    protected $commandOptionName = "namespace";
    protected $commandOptionDescription = 'Namespace of the controller';
    protected $commandHelp = "This command allows you to create a controller";
    protected $content = "<?php
    namespace %s;

    class %sController
    {
        public function index()
        {
            echo 'Hello World';
        }
    }
    ";

    public function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::REQUIRED,
                $this->commandArgumentDescription,
                null
            )
            ->addOption(
                $this->commandOptionName,
                null,
                InputOption::VALUE_OPTIONAL,
                $this->commandOptionDescription,
                'Boolnut\App\Controllers'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        $name = Helper::camelCase($input->getArgument($this->commandArgumentName));
        $namespace = $input->getOption($this->commandOptionName);
        $DirName = explode('/', $name);
        $filePath = 'app/controllers/';

        if(count($DirName) == 2)
        {
           $filePath = Helper::lowerCase($filePath.$DirName[0]);
           $namespace = $namespace.'\\'.Helper::capitalizedCase($DirName[0]);
           $name = Helper::capitalizedCase($DirName[1]);
           Helper::makeDir($filePath);
        }
        else if(count($DirName) == 3)
        {
            $filePath = Helper::lowerCase($filePath.$DirName[0].$DirName[1]);
            $namespace = $namespace.'\\'.Helper::capitalizedCase($DirName[0]).'\\'.Helper::capitalizedCase($DirName[1]);
            $name = Helper::capitalizedCase($DirName[2]);
            Helper::makeDir($filePath);
        }
        else if(count($DirName) == 4)
        {
            $filePath = Helper::lowerCase($filePath.$DirName[0].$DirName[1].$DirName[2]);
            $namespace = $namespace.'\\'.Helper::capitalizedCase($DirName[0]).'\\'.Helper::capitalizedCase($DirName[1]).'\\'.Helper::capitalizedCase($DirName[2]);
            $name = Helper::capitalizedCase($DirName[3]);
            Helper::makeDir($filePath);
        }

        
        if (!file_exists($filePath.'/'.$name.'Controller.php')) {

            $fh = fopen($filePath.'/'.$name.'Controller.php', 'w') or die("Can't create file");
            $content = sprintf($this->content, $namespace ,$name);
            fwrite($fh, $content);
            fclose($fh);
            $fh = ("Controller created successfully");
        }
        else
        {
            $fh = ("Controller already exists");
        }
        

        $output->writeln($fh);
    }

}