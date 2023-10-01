<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpertController extends AbstractController
{
    #[Route('/dashboard/expert', name: 'app_dashboard_expert')]
    public function index(): Response
    {
        return $this->render('dashboard/expert/index.html.twig', [
            'controller_name' => 'ExpertController',
        ]);
    }
}
