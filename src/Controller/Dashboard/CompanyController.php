<?php

namespace App\Controller\Dashboard;

use App\Entity\Company;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private EntityManagerInterface $em,
    ){
    }
    
    #[Route('/dashboard/company', name: 'app_dashboard_company')]
    public function index(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/posting', name: 'app_dashboard_company_posting')]
    public function posting(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/posting/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/posting/new', name: 'app_dashboard_company_posting_new')]
    public function postingNew(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/posting/new.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/posting/all', name: 'app_dashboard_company_posting_all')]
    public function postingAll(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/posting/all.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/profile', name: 'app_dashboard_company_profile')]
    public function profile(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/profile/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/message', name: 'app_dashboard_company_message')]
    public function message(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/message/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/notification', name: 'app_dashboard_company_notification')]
    public function notification(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/notification/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/account', name: 'app_dashboard_company_account')]
    public function account(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $company = $identity->getCompany();
        if(!$company instanceof Company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/account/index.html.twig', [
            'company' => $company,
        ]);
    }
}
