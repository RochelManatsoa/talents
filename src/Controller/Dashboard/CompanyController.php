<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    #[Route('/dashboard/company', name: 'app_dashboard_company')]
    public function index(): Response
    {
        return $this->render('dashboard/company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }
}
