<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre'),
            TextField::new('players','Nombre de joueurs'),
            IntegerField::new('time', "Durée d'une partie en minutes"),
            IntegerField::new('age', "Date minimum"),
            DateField::new('released', "Date de la publication"),
            IntegerField::new('age', "Date minimum"),
            TextareaField::new('description', "Description"),
            TextareaField::new('content', "Matériel de jeu"),
            IntegerField::new('age', "Date minimum"),
            ImageField::new('picture')->setBasePath('uploads/')->setUploadDir('public/uploads/')->setFormTypeOption('required', false),
            AssociationField::new('categories', "Catégories"),

        ];

    }
}
