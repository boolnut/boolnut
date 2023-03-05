<?php

namespace Boolnut\Core\Inc\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface CommandInterface
{
    public function configure();
    public function execute(InputInterface $input, OutputInterface $output);
}
