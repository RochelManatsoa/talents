<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\Expert;
use App\Entity\Posting;
use App\Entity\Sector;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(PostingCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Talents');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Annonces', 'fas fa-bullhorn', Posting::class);
        yield MenuItem::linkToCrud('Entreprise', 'fas fa-building', Company::class);
        yield MenuItem::linkToCrud('Expert', 'fas fa-user-tie', Expert::class);
        yield MenuItem::linkToCrud('Secteur', 'fas fa-tags', Sector::class);
        yield MenuItem::linkToCrud('Candidature', 'fas fa-clipboard-user', Application::class);
    }
}
