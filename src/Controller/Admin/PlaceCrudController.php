<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Place::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id'),
            Field::new('room'),
            Field::new('floor'),
            Field::new('name'),
            Field::new('kit'),
            Field::new('country'),
            Field::new('result'),
            AssociationField::new('times'),
            AssociationField::new('tester')
        ];
    }

}
