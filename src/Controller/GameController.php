<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Game;
use App\Form\GameType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    #[Route('/game/new', name: 'app_add_game')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $newgame = new Game;
        $form = $this->createForm(GameType::class, $newgame)
            ->add('enregister', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newgame = $form->getData();
            $em->persist($newgame);
            $em->flush();
        }

        return $this->render('game/add.html.twig', [
            'controller_name' => 'GameController',
            'form' => $form
        ]);
    }
}
