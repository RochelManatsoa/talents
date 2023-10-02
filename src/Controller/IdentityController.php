<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdentityController extends AbstractController
{
    #[Route('/identity/create', name: 'app_identity_create')]
    public function index(): Response
    {
        return $this->render('identity/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/identity/account', name: 'app_identity_account')]
    public function account(): Response
    {
        return $this->render('identity/account.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/identity/company', name: 'app_identity_company')]
    public function company(): Response
    {
        return $this->render('identity/company.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/identity/expert', name: 'app_identity_expert')]
    public function expert(): Response
    {
        return $this->render('identity/expert.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
