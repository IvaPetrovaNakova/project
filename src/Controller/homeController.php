<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class homeController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]

    public function homepage(): Response
    {
        return new Response('ROCK -- PAPER -- SCISSORS');
    }
}