<?php

namespace App\Controller;

use App\Entity\Ouvrier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class OuvrierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ouvrier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            DateField::new('daten', 'Date de naissance'),
            NumberField::new('salaire', 'Salaire'),
        ];
    }
}