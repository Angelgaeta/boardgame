<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Form\GameType;



class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(GameRepository $repo): Response
    {
        $games = $repo->findAll();
        dump($games);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'GameController',
            'games' => $games
        ]);
    }
}



