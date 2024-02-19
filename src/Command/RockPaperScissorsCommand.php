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
        $playerMove=$this->getUserMove($input,$output);

        if ($playerMove === null) {
            return Command::FAILURE;
        }

        $computerMove = $this->getComputerMove();
        $output->writeln("You chose: $playerMove");
        $output->writeln("The computer chose: $computerMove");

        $this->determineWinner($output, $playerMove, $computerMove);
        return Command::SUCCESS;


    }

    private function getUserMove(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Choose: [r]ock, [p]aper, [s]cissors: ');
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
        switch (strtolower($input)) {
            case "r":
            case "rock":
                return self::ROCK;
            case "p":
            case "paper":
                return self::PAPER;
            case "s":
            case "scissors":
                return self::SCISSORS;
            default:
                return null; // Handle invalid input
        }
    }

    private function determineWinner(OutputInterface $output, $playerMove, $computerMove)
    {
        //Instead of directly checking if the door is open and then deciding
        // whether to go through, I try first to approach the door and then to make
        // decisions based on its properties

        $choices = [
            'rock' => ['scissors' => 'You win.', 'paper' => 'You lose.'],
            'paper' => ['rock' => 'You win.', 'scissors' => 'You lose.'],
            'scissors' => ['paper' => 'You win.', 'rock' => 'You lose.']
        ];

        // Ignore typing mistake - or is it not necessary??
        $playerMove = strtolower($playerMove);
        $computerMove = strtolower($computerMove);

        // Check if moves are valid
        if (!isset($outcomes[$playerMove]) || !isset($outcomes[$computerMove])) {
            $output->writeln("Invalid moves. No result.");
            return;
        }

        // Show the result
        if ($playerMove === $computerMove) {
            $output->writeln("This game was a draw.");
        } else {
            $result = $outcomes[$playerMove][$computerMove];
            $output->writeln($result);
        }
    }
}