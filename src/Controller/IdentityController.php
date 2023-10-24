<?php

namespace App\Controller;

use App\Entity\Expert;
use App\Entity\Company;
use App\Entity\Identity;
use App\Form\ExpertType;
use App\Form\CompanyType;
use App\Form\IdentityType;
use App\Form\Step\StepOneType;
use App\Form\Step\StepTwoType;
use App\Form\Step\StepTreeType;
use App\Manager\IdentityManager;
use App\Form\AccountIdentityType;
use App\Service\User\UserService;
use App\Service\Mailer\MailerService;
use App\Service\Posting\PostingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdentityController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private EntityManagerInterface $em,
        private IdentityManager $identityManager,
        private PostingService $postingService,
        private RequestStack $requestStack,
        private UrlGeneratorInterface $urlGenerator,
    ){
    }
    
    #[Route('/identity/create', name: 'app_identity_create')]
    public function index(): Response
    {
        dump($this->postingService->getPostingSession());
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
    public function account(Request $request, MailerService $mailerService): Response
    {
        dump($this->postingService->getPostingSession());
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
            $mailerService->send(
                $identity->getUser()->getEmail(),
                "Bienvenue sur Olona Talents",
                "welcome.html.twig",
                [
                    'user' => $identity->getUser(),
                    'dashboard_url' => $this->urlGenerator->generate('app_connect', [], UrlGeneratorInterface::ABSOLUTE_URL),
                ]
            );
            if($identity->getAccount()->getSlug() !== "expert" ) return $this->redirectToRoute('app_identity_company', []);
            
            return $this->redirectToRoute('app_identity_expert_step_one', []);
        }

        return $this->render('identity/account.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/company', name: 'app_identity_company')]
    public function company(Request $request): Response
    {
        dump($this->userService->getStoredURI());
        dump($this->requestStack->getCurrentRequest()->getSession());
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

    #[Route('/identity/expert/create', name: 'app_identity_expert_create')]
    public function createExpert(Request $request): Response
    {
        dump($this->postingService->getPostingSession());
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();

        if (!$expert instanceof Expert) {
            $expert = $this->identityManager->createExpert($identity);
        }

        $form = $this->createForm(IdentityType::class, $expert->getIdentity(), []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $identity = $form->getData();
            dd($identity);
            $this->em->persist($expert);
            $this->em->flush();

            return $this->redirectToRoute('app_identity_confirmation', []);
        }

        return $this->render('identity/create.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/expert/step-one', name: 'app_identity_expert_step_one')]
    public function stepOne(Request $request): Response
    {
        dump($this->postingService->getPostingSession());
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();

        if (!$expert instanceof Expert) {
            $expert = $this->identityManager->createExpert($identity);
        }

        $form = $this->createForm(StepOneType::class, $identity, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $identity = $this->identityManager->saveForm($form);

            return $this->redirectToRoute('app_identity_expert_step_two', []);
        }

        return $this->render('identity/step/step_one.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/expert/step-two', name: 'app_identity_expert_step_two')]
    public function stepTwo(Request $request): Response
    {
        dump($this->postingService->getPostingSession());
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();

        if (!$expert instanceof Expert) {
            $expert = $this->identityManager->createExpert($identity);
        }
        $initialCounts = [
            'technicalSkills' => count($identity->getTechnicalSkills()),
            'formations' => count($identity->getFormations()),
            'experiences' => count($identity->getExperiences()),
            'languages' => count($identity->getLanguages())
        ];
        $form = $this->createForm(StepTwoType::class, $identity, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $identity = $this->identityManager->saveForm($form);
            $reloadSamePage = false;
            foreach ($initialCounts as $field => $initialCount) {
                if (count($form->get($field)->getData()) !== $initialCount) {
                    $reloadSamePage = true;
                    break;
                }
            }

            if ($reloadSamePage) {
                // Si le nombre d'éléments dans un des CollectionType a changé, rechargez la même page
                return $this->redirectToRoute('app_identity_expert_step_two', []);
            } else {
                // Sinon, redirigez vers app_identity_expert_step_three
                return $this->redirectToRoute('app_identity_expert_step_three', []);
            }
        }

        return $this->render('identity/step/step_two.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'formations' => $identity->getFormations(),
            'technicalSkills' => $identity->getTechnicalSkills(),
            'experiences' => $identity->getExperiences(),
            'languages' => $identity->getLanguages(),
        ]);
    }

    #[Route('/identity/expert/step-three', name: 'app_identity_expert_step_three')]
    public function stepThree(Request $request): Response
    {
        dump($this->requestStack->getCurrentRequest()->getSession()->get('_security.main.target_path'));
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();

        if (!$expert instanceof Expert) {
            $expert = $this->identityManager->createExpert($identity);
        }

        $form = $this->createForm(StepTreeType::class, $identity, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $identity = $this->identityManager->saveForm($form);

            return $this->redirectToRoute('app_identity_confirmation', []);
        }

        return $this->render('identity/step/step_three.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/identity/confirmation', name: 'app_identity_confirmation')]
    public function confirmation(): Response
    {
        dump($this->postingService->getPostingSession());
        $redirect = $this->requestStack->getCurrentRequest()->getSession()->get('_security.main.target_path');
        $originalURI = $this->userService->getStoredURI();
    
        if ($originalURI) {
            $this->userService->removeStoredURI('original_uri_before_registration');
            return $this->redirectToRoute($originalURI);
        }
        if($redirect){
            return $this->redirectToRoute($redirect);
        }
        return $this->render('identity/confirmation.html.twig', [
            'controller_name' => 'IdentityController',
        ]);
    }
}
