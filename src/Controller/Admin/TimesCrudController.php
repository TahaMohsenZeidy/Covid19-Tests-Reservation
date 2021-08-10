<?php

namespace App\Controller\Admin;

use App\Entity\Times;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class TimesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Times::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id'),
            Field::new('timeBegin'),
            Field::new('timeFinish'),
        ];
    }

}
