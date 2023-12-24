<?php

    namespace App;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class rpsCommand extends Command
    {
        const ROCK = "Rock";
        const PAPER = "Paper";
        const SCISSORS = "Scissors";

        protected function configure()
        {
            $this->setName('rps:play')
                ->setDescription('Play Rock, Paper, Scissors game');
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $playerMove = $this->getUserMove($input, $output);

            if ($playerMove === null) {
                return Command::FAILURE; // Handle invalid user input
            }

            $computerMove = $this->getComputerMove();
            $output->writeln("The computer chose: $computerMove");

            $this->determineWinner($output, $playerMove, $computerMove);

            return Command::SUCCESS;
        }

        private function getUserMove(InputInterface $input, OutputInterface $output)
        {
            $inputText = $this->getHelper('question')->ask($input, $output,
                $this->getQuestionHelper('Choose: [r]ock, [p]aper, [s]cissors: ')
            );

            return $this->convertInputToMove($inputText);
        }

        private function getComputerMove()
        {
            $computerRandomNumber = rand(1, 3);

            switch ($computerRandomNumber) {
                case 1:
                    return self::ROCK;
                case 2:
                    return self::PAPER;
                case 3:
                    return self::SCISSORS;
            }

            return null; // Handle invalid case
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
            if (($playerMove === self::ROCK && $computerMove === self::SCISSORS)
                || ($playerMove === self::SCISSORS && $computerMove === self::PAPER)
                || ($playerMove === self::PAPER && $computerMove === self::ROCK)) {
                $output->writeln("You win.");
            } elseif (($playerMove === self::SCISSORS && $computerMove === self::ROCK)
                || ($playerMove === self::PAPER && $computerMove === self::SCISSORS)
                || ($playerMove === self::ROCK && $computerMove === self::PAPER)) {
                $output->writeln("You lose.");
            } else {
                $output->writeln("This game was a draw.");
            }
        }
}

