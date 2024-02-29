<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class RockPaperScissorsCommand extends Command
{
    const ROCK = 'rock';
    const PAPER = 'paper';
    const SCISSORS = 'scissors';

    protected function configure()
    {
        $this->setName('rps:play')
            ->setDescription('Play Rock, Paper, Scissors game');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerMove=$this->getPlayerMove($input,$output);

//        if ($playerMove === null) {
//            return Command::FAILURE;
//        }

        $computerMove = $this->getComputerMove();
        $output->writeln("You chose: $playerMove");
        $output->writeln("The computer chose: $computerMove");

        $this->determineWinner($output, $playerMove, $computerMove);
        return Command::SUCCESS;
    }

    private function getPlayerMove(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Choose: rock, paper, scissors: ');
        $inputText = $helper->ask($input, $output, $question);

        return $this->convertInputToMove($inputText);
    }

    private function getComputerMove(){
        {
            $moves = [self::ROCK, self::PAPER, self::SCISSORS];
            $randomIndex = array_rand($moves);
            return $moves[$randomIndex];
        }
    }

    private function convertInputToMove($input)
    {
        return match (strtolower($input)) {
            "rock" => self::ROCK,
            "paper" => self::PAPER,
            "scissors" => self::SCISSORS,
            default => null,
        };
    }

    private function validateMove($move): bool
    {
        return in_array(strtolower($move), ['rock', 'paper', 'scissors']);
    }

    private function determineWinner(OutputInterface $output, $playerMove, $computerMove): void
    {

        // Validate player moves! What is the good practise -here or in execute function, unable the Command FAILURE
        if (!$this->validateMove($playerMove) || !$this->validateMove($computerMove)) {
            $output->writeln("Invalid moves. No result.");
            return;
        }

        //Instead of directly checking if the door is open and then deciding
        // whether to go through, I try first to approach the door and then to make
        // decisions based on its properties
        //Game logic
        $choices = [
            'rock' => ['scissors' => 'You win.', 'paper' => 'You lose.'],
            'paper' => ['rock' => 'You win.', 'scissors' => 'You lose.'],
            'scissors' => ['paper' => 'You win.', 'rock' => 'You lose.']
        ];

        $playerMove = strtolower($playerMove);
        $computerMove = strtolower($computerMove);

        // Show the result
        if ($playerMove === $computerMove) {
            $output->writeln("This game was a draw.");
        } else {
            $result = $choices[$playerMove][$computerMove];
            $output->writeln($result);
        }
    }
}