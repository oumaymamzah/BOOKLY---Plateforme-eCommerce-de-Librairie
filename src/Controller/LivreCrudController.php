<?php

namespace App\Controller;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre', 'Titre'),
            TextField::new('isbn', 'ISBN'),
            NumberField::new('prixUnitaire', 'Prix'),
            NumberField::new('qte', 'Qté'),
            TextField::new('datepubFormatted', 'Date Pub')
                ->onlyOnIndex()
                ->onlyOnDetail(),
            TextField::new('datepubFormatted', 'Date Pub')
                ->setFormType(\Symfony\Component\Form\Extension\Core\Type\TextType::class)
                ->onlyOnForms(),
            AssociationField::new('categorie', 'Catégorie'),
            AssociationField::new('editeurs', 'Éditeur'),
            AssociationField::new('auteurs', 'Auteurs')->setFormTypeOption('by_reference', false),
            ImageField::new('pdfFilename', 'Book Photo')
                ->setBasePath('uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
                ->setRequired(false)
                ->setFormTypeOptions([
                    'constraints' => [],
                ])
                ->setHelp('Select a book cover image (JPG, PNG, GIF)'),
            TextareaField::new('description', 'Description')
                ->setRequired(false)
                ->setHelp('Enter a description for the book'),
        ];
    }
}