<?php

namespace App\Controller;

use App\Entity\Expert;
use App\Entity\Company;
use App\Entity\Identity;
use App\Form\ExpertType;
use App\Form\CompanyType;
use App\Manager\IdentityManager;
use App\Form\AccountIdentityType;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdentityController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private EntityManagerInterface $em,
        private IdentityManager $identityManager,
    ){
    }
    
    #[Route('/identity/create', name: 'app_identity_create')]
    public function index(): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        if($identity instanceof Identity){
            $compagny = $identity->getCompany();
            if($compagny instanceof Company){
                return $this->redirectToRoute('app_dashboard_company');
            }
            $expert = $identity->getExpert();
            if($expert instanceof Expert){
                return $this->redirectToRoute('app_dashboard_expert');
            }

            return $this->redirectToRoute('app_identity_account');
        }

        return $this->render('identity/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/identity/account', name: 'app_identity_account')]
    public function account(Request $request): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        if(!$identity instanceof Identity){
            $identity = $this->identityManager->init();
            $identity->setUser($this->getUser());
            $this->identityManager->save($identity);
        }

        $form = $this->createForm(AccountIdentityType::class, $identity, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $identity = $this->identityManager->saveForm($form);
            if($identity->getAccount()->getSlug() !== "expert" ) return $this->redirectToRoute('app_identity_company', []);
            
            return $this->redirectToRoute('app_identity_expert', []);
        }

        return $this->render('identity/account.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/company', name: 'app_identity_company')]
    public function company(Request $request): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $compagny = $identity->getCompany();

        if (!$compagny instanceof Company) {
            $compagny = $this->identityManager->createCompagny($identity);
        }

        $form = $this->createForm(CompanyType::class, $compagny, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $compagny = $form->getData();
            $this->em->persist($compagny);
            $this->em->flush();

            return $this->redirectToRoute('app_identity_confirmation', []);
        }

        return $this->render('identity/company.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/expert', name: 'app_identity_expert')]
    public function expert(Request $request): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();

        if (!$expert instanceof Expert) {
            $expert = $this->identityManager->createExpert($identity);
        }

        $form = $this->createForm(ExpertType::class, $expert, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $expert = $form->getData();
            $this->em->persist($expert);
            $this->em->flush();

            return $this->redirectToRoute('app_identity_confirmation', []);
        }

        return $this->render('identity/expert.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/confirmation', name: 'app_identity_confirmation')]
    public function confirmation(): Response
    {
        return $this->render('identity/confirmation.html.twig', [
            'controller_name' => 'IdentityController',
        ]);
    }
}
