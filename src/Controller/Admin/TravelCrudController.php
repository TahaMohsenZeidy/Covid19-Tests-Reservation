<?php

namespace App\Controller\Admin;

use App\Entity\Travel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class TravelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Travel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id'),
            Field::new('flydate'),
            Field::new('destination'),
        ];
    }
}
