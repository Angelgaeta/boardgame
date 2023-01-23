<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Game;
use App\Form\GameType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\GameRepository;
use Symfony\Component\String\Slugger\SluggerInterface;



class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(GameRepository $repo): Response
    {
        $games = $repo->findAll();
        dump($games);
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games'=> $games
        ]);
    }

    #[Route('/game/new', name: 'app_add_game')]
    public function add(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        
        $newgame = new Game;

        $form = $this->createForm(GameType::class, $newgame)
            ->add('enregister', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $pictureFile = $form->get('picture')->getData();
            $newgame = $form->getData();
            if($pictureFile){
            $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();

            try {
            $pictureFile->move(
            $this->getParameter('pictures_directory'),
            $newFilename
            );
            } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            }

            $newgame->setPicture($newFilename);
            }
            $em->persist($newgame);
            $em->flush(); 
            }
        

        return $this->render('game/add.html.twig', [
            'controller_name' => 'GameController',
            'form' => $form
        ]);
    }

    #[Route('/game/{id}', name: 'app_show_game')]
    public function show(gameRepository $repo, $id): Response{
        $games = $repo->find($id);
        //dump($games);
        return $this->render('game/show.html.twig', [
            'games' => $games
    
        ]);
    }
}
