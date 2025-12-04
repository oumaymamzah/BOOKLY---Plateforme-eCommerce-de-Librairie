<?php

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            ArrayField::new('roles'),
            TextField::new('createdAtFormatted', 'Created At')->hideOnForm(),
            TextField::new('updatedAtFormatted', 'Updated At')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Action::INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}