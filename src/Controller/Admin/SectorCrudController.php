<?php

namespace App\Controller\Admin;

use App\Entity\Sector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SectorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sector::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
