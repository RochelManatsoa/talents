<?php

namespace App\Controller\Catalog;

use DateTime;
use App\Entity\Posting;
use App\Entity\Identity;
use App\Entity\Application;
use App\Entity\Views\IdentityViews;
use App\Form\ApplicationType;
use App\Service\User\UserService;
use App\Entity\Views\PostingViews;
use App\Repository\SectorRepository;
use App\Repository\PostingRepository;
use App\Repository\IdentityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogController extends AbstractController
{
    public function __construct(
        private PostingRepository $postingRepository,
        private IdentityRepository $identityRepository,
        private SectorRepository $sectorRepository,
        private UserService $userService,
        private EntityManagerInterface $em,
    ){
    }
    
    #[Route('/catalog/expert/{username}', name: 'app_catalog_expert')]
    public function expert(Identity $identity, Request $request): Response
    {

        if ($identity) {
            $ipAddress = $request->getClientIp();
            $viewRepository = $this->em->getRepository(IdentityViews::class);
            $existingView = $viewRepository->findOneBy([
                'identity' => $identity,
                'ipAdress' => $ipAddress,
            ]);
    
            if (!$existingView) {
                $view = new IdentityViews();
                $view->setIdentity($identity);
                $view->setIpAdress($ipAddress);
    
                $this->em->persist($view);
                $identity->addView($view);
                $this->em->flush();
            }
        }
        return $this->render('catalog/expert/view.html.twig', [
            'identity' => $identity,
        ]);
    }
    
    #[Route('/catalog/posting/{jobId}', name: 'app_catalog_posting')]
    public function posting(Posting $posting, Request $request): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $application = new Application();
        $application->setCreatedAt(new DateTime());
        $application->setPosting($posting);
        $application->setIdentity($identity);
        $application->setStatus(Application::STATUS_PENDING);
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($application);
            $this->em->flush();
    
            $this->addFlash('success', "Candidature envoyé ");
        }

        if ($posting) {
            $ipAddress = $request->getClientIp();
            $viewRepository = $this->em->getRepository(PostingViews::class);
            $existingView = $viewRepository->findOneBy([
                'posting' => $posting,
                'ipAdress' => $ipAddress,
            ]);
    
            if (!$existingView) {
                $view = new PostingViews();
                $view->setPosting($posting);
                $view->setIpAdress($ipAddress);
    
                $this->em->persist($view);
                $posting->addView($view);
                $this->em->flush();
            }
        }
        
        return $this->render('catalog/posting/view.html.twig', [
            'posting' => $posting,
            'company' => $posting->getCompany(),
            'form' => $form->createView(),
        ]);
    }
}
