<?php

namespace App\Controller\Admin;

use App\Entity\Rdv;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RdvCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rdv::class;
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
