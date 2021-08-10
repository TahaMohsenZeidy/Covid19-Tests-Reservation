<?php

namespace App\Controller\Admin;

use App\Entity\Symptomes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SymptomesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Symptomes::class;
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
