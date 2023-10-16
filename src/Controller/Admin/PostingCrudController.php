<?php

namespace App\Controller\Admin;

use App\Entity\Posting;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostingCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;
     
    public static function getEntityFqcn(): string
    {
        return Posting::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            MoneyField::new('tarif')->setCurrency('EUR')->onlyOnForms(),
            ChoiceField::new('status')->setChoices(Posting::getStatuses()),
        ];
    }
}
