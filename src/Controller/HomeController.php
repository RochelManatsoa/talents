<?php

namespace App\Controller;

use App\Repository\IdentityRepository;
use App\Repository\PostingRepository;
use App\Repository\SectorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function __construct(
        private PostingRepository $postingRepository,
        private IdentityRepository $identityRepository,
        private SectorRepository $sectorRepository,
    ){
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'sectors' => $this->sectorRepository->findAll(),
            'experts' => $this->identityRepository->findSearch(),
            'topRanked' => $this->identityRepository->findTopRanked(),
            'postings' => $this->postingRepository->findValid(),
        ]);
    }

    #[Route('/experts', name: 'app_home_experts')]
    public function experts(): Response
    {
        return $this->render('home/experts.html.twig', [
            'experts' => $this->identityRepository->findSearch(),
        ]);
    }

    #[Route('/posting', name: 'app_home_posting')]
    public function posting(): Response
    {
        return $this->render('home/posting.html.twig', [
            'postings' => $this->postingRepository->findAll(),
        ]);
    }

    #[Route('/formation', name: 'app_home_formation')]
    public function formation(): Response
    {
        return $this->render('home/formation.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'app_home_contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/ia-good-deal', name: 'app_home_ia')]
    public function ia(): Response
    {
        return $this->render('home/ia-good-deal.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/legal-mentions', name: 'app_home_legal')]
    public function legal(): Response
    {
        return $this->render('home/legal.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/privacy-policy', name: 'app_home_privacy')]
    public function privacy(): Response
    {
        return $this->render('home/privacy.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/terms-and-conditions', name: 'app_home_terms')]
    public function terms(): Response
    {
        return $this->render('home/terms.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
