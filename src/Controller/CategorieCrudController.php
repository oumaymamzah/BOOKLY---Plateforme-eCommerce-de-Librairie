<?php

namespace App\Controller;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextareaField::new('designation', 'Désignation'),
            ImageField::new('imageFilename', 'Image')
                ->setBasePath('uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('livres', 'Livres')->hideOnForm(),
        ];
    }
}