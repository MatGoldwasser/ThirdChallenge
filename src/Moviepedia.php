<?php

namespace Name;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;


class Moviepedia extends Command
{
    public function configure()
    {
        $this->setName('show')
             ->setDescription('Get information about movie')
             ->addArgument('movie', InputArgument::REQUIRED)
             ->addOption('fullPlot', null, InputOption::VALUE_OPTIONAL, 'Display the movie full plot', false);

    }

    public function execute(InputInterface $input, OutputInterface $output):int
    {

        $client = new Client();
        $api = '58ec4ac5';
        $movie = $input->getArgument('movie');

        if(false === $input->getOption('fullPlot')){
            $response = $client->request('GET', 'http://www.omdbapi.com/', [
                'query' => ['apikey' => $api,
                    't' => $movie]
            ]);
        }else{
            $response = $client->request('GET', 'http://www.omdbapi.com/', [
                'query' => ['apikey' => $api,
                    't' => $movie,
                    'plot' => 'full']]);
        }

        $contents = $response->getBody()->getContents();

        $movie_info = json_decode($contents, true);

        if(strcmp($movie_info["Response"], "False") == 0){
            $output->writeln("<info>That movie doesn't exist!</info>");
        }else{
            $table = new Table($output);
            $table->setHeaders(['Clave', 'Valor']);
            $output->writeln("<info>{$movie} - {$movie_info["Year"]}</info>");
            foreach($movie_info as $clave=>$valor){
                $table->addRow([strval($clave),strval($valor)]);
            }
            $table->render();
        }
        return Command::SUCCESS;
    }
}