<?php

namespace App\Controller\Admin;
use App\Entity\Image;
use App\Entity\MedicalHistory;
use App\Entity\Patient;
use App\Entity\Place;
use App\Entity\Rdv;
use App\Entity\Symptomes;
use App\Entity\Tester;
use App\Entity\Times;
use App\Entity\Travel;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin_dashboard_index")
     * @return Response
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(RdvCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Items');
        yield MenuItem::linkToCrud('Appointments', 'fa fa-calendar', Rdv::class);
        yield MenuItem::linkToCrud('Patients', 'fa fa-user', Patient::class);
        yield MenuItem::linkToCrud('Medical History', 'fa fa-history', MedicalHistory::class);
        yield MenuItem::linkToCrud('Travel', 'fas fa-bus', Travel::class);
        yield MenuItem::linkToCrud('Place', 'fas fa-map-marker', Place::class);
        yield MenuItem::linkToCrud('Tester', 'fa fa-medkit', Tester::class);
        yield MenuItem::linkToCrud('Times', 'fa fa-times', Times::class);
        yield MenuItem::linkToCrud('Symptomes', 'fa fa-list', Symptomes::class);
        yield MenuItem::linkToCrud('Images', 'fa fa-picture-o', Image::class);


    }
}
