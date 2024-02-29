<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RockPaperScissorsController extends AbstractController
{

    #[Route('game/description' , name: 'read_description')]
    public function description(Request $request): Response
    {
        return $this->render('game/description.html.twig');
    }

    const ROCK = 'rock';
    const PAPER = 'paper';
    const SCISSORS = 'scissors';

    #[Route('game/play', name: 'playing_game')]
    public function play(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $playerMove = $request->request->get('move');
            $computerMove = $this->getComputerMove();

            // Check if player move is valid
            if (!in_array(strtolower($playerMove), ['rock', 'paper', 'scissors'])) {
                return new Response("Invalid move. Please choose: rock, paper, scissors.");
            }

            $result = $this->determineWinner($playerMove, $computerMove);

            return $this->render('game/play.html.twig', [
                'playerMove' => $playerMove,
                'computerMove' => $computerMove,
                'result' => $result,
            ]);
        }

        return $this->render('game/index.html.twig');
    }

    private function getComputerMove()
    {
        $moves = [self::ROCK, self::PAPER, self::SCISSORS];
        $randomIndex = array_rand($moves);
        return $moves[$randomIndex];
    }

    private function validateMove($move)
    {
        return in_array(strtolower($move), ['rock', 'paper', 'scissors']);
    }

    private function determineWinner($playerMove, $computerMove)
    {
        $choices = [
            'rock' => ['scissors' => 'You win!', 'paper' => 'You lose!'],
            'paper' => ['rock' => 'You win!', 'scissors' => 'You lose!'],
            'scissors' => ['paper' => 'You win!', 'rock' => 'You lose!']
        ];

        // Ignore typing mistake
        $playerMove = strtolower($playerMove);
        $computerMove = strtolower($computerMove);

        // Show the result
        if ($playerMove === $computerMove) {
            return "This game was a draw.";
        } else {
            return $choices[$playerMove][$computerMove];
        }
    }

    #[Route('/', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'RockPaperScissorsController',
        ]);
    }
}
