<?php

namespace App\Controller\Dashboard;

use App\Entity\Expert;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private EntityManagerInterface $em,
    ){
    }

    #[Route('/dashboard/expert', name: 'app_dashboard_expert')]
    public function index(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/expert/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/posting', name: 'app_dashboard_expert_posting')]
    public function posting(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/posting/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/posting/all', name: 'app_dashboard_expert_posting_all')]
    public function all(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/posting/all.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/formation', name: 'app_dashboard_expert_formation')]
    public function formation(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/formation/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/tools', name: 'app_dashboard_expert_tools')]
    public function tools(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/tools/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/application', name: 'app_dashboard_expert_application')]
    public function application(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/application/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/message', name: 'app_dashboard_expert_message')]
    public function message(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/message/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/notification', name: 'app_dashboard_expert_notification')]
    public function notification(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/notification/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/account', name: 'app_dashboard_expert_account')]
    public function account(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/account/index.html.twig', [
            'identity' => $identity,
        ]);
    }

    #[Route('/dashboard/expert/profile', name: 'app_dashboard_expert_profile')]
    public function profile(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        return $this->render('dashboard/expert/profile/index.html.twig', [
            'identity' => $identity,
        ]);
    }
}
