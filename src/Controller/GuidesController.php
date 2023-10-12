<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuidesController extends AbstractController
{
    #[Route('/guides/lettre-de-motivation', name: 'app_guides_motivation')]
    public function motivation(): Response
    {
        return $this->render('guides/motivation.html.twig', [
            'controller_name' => 'GuidesController',
        ]);
    }

    #[Route('/guides/cv', name: 'app_guides_cv')]
    public function cv(): Response
    {
        return $this->render('guides/cv.html.twig', [
            'controller_name' => 'GuidesController',
        ]);
    }

    #[Route('/guides/reseautage', name: 'app_guides_reseautage')]
    public function reseautage(): Response
    {
        return $this->render('guides/reseautage.html.twig', [
            'controller_name' => 'GuidesController',
        ]);
    }
    
}
