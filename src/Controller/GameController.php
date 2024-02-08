<?php

namespace App\Controller;

use App\Command\RockPaperScissorsCommand;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    #[Route('game/description' , name: 'read_description')]
    public function description(Request $request): Response
    {
        return $this->render('game/description.html.twig');
    }

    #[Route('game/play' , name: 'playing_game')]
    public function play(Request $request): Response
    {

        return $this->render('game/play.html.twig');
    }


//    /**
//     * @throws Exception
//     */
//    #[Route('/game/play' , name: 'playing_game')]
//    public function play(Request $request): Response
//    {
//        // Create a Symfony Console application
//        $application = new Application();
//
//        // Add the RockPaperScissorsCommand to the application
//        $application->add(new RockPaperScissorsCommand());
//
//
//        $input = new ArrayInput(['command' => 'rps:play']);
//
//        // You can use NullOutput() if you don't need the output
//        $output = new BufferedOutput();
//
//        // Run the command
//        $application->setAutoExit(false); // Prevent console from terminating
//        $application->run($input, $output);
//
//        // return the output, don't use if you used NullOutput()
//        $result = $output->fetch();
//
//        // return new Response(""), if you used NullOutput()
//        return $this->render('game/play.html.twig', ['result' => $result]);
//    }

    #[Route('/', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
