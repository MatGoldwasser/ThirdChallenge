<?php

namespace Name;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;


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

        $client = new Client();
        $api = '58ec4ac5';
        $movie = $input->getArgument('movie');

        $response = $client->request('GET', 'http://www.omdbapi.com/', [
            'query' => ['apikey' => $api,
                        't' => $movie]
        ]);

        $contents = $response->getBody()->getContents();
        $movie_info = json_decode($contents, true);

        $output->writeln("<info>{$movie_info["Year"]}</info>");

    }

}