<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('motivation')->onlyOnForms(),
            TextField::new('identity.user.firstName', 'Nom'),
            TextField::new('identity.user.lastName', 'Prénoms'),
            ChoiceField::new('status')->setChoices(Application::getStatuses()),
            TextField::new('posting.title', 'Annonce'),
            TextField::new('posting.company.name', 'Entreprise'),
        ];
    }
}
