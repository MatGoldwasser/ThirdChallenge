<?php

namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Moviepedia extends Command
{
    public function configure()
    {
        $this->setName('show')
             ->setDescription('Get information about movie')
             ->addArgument('movie', InputArgument::REQUIRED);

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //$client = new GuzzleHttp\Client();
        //$api = '58ec4ac5';

        $message = 'A Felipe le gusta '. $input->getArgument('movie');
        $output->writeln("<info>{$message}</info>");

    }

}