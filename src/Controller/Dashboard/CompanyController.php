<?php

namespace App\Controller\Dashboard;

use App\Entity\Account;
use App\Entity\Company;
use App\Entity\Posting;
use App\Form\CompanyType;
use App\Manager\ExpertManager;
use App\Manager\PostingManager;
use App\Entity\Type\PostingType;
use App\Service\User\UserService;
use App\Form\PostingType as Annonce;
use App\Form\Search\ExpertSearchType;
use App\Repository\IdentityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private EntityManagerInterface $em,
        private PostingManager $postingManager,
        private IdentityRepository $identityRepository,
        private ExpertManager $expertManager,
        private RequestStack $requestStack,
    ){
    }

    private function getCompanyOrRedirect(): ?Company
    {
        $identity = $this->userService->getCurrentIdentity();
        $account = $identity->getAccount();
        if (!$account instanceof Account) return $this->redirectToRoute('app_identity_account');
        $company = $identity->getCompany();
        if (!$company instanceof Company) return null;

        return $company;
    }

    #[Route('/dashboard/company', name: 'app_dashboard_company')]
    public function index(): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');
        [ $postingsOk, $postingsFail ] = $this->postingManager->splitPostingsByValidity($company);

        return $this->render('dashboard/company/index.html.twig', [
            'company' => $company,
            'postingsOk' => $postingsOk,
            'postingsFail' => $postingsFail,
            'postings' => $company->getPostings(),
            'experts' => $this->expertManager->allExpert(),
        ]);
    }
    
    #[Route('/dashboard/company/posting', name: 'app_dashboard_company_posting')]
    public function posting(): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/posting/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/posting/edit/{jobId}', name: 'app_dashboard_company_posting_edit')]
    public function edit(Posting $posting, Request $request): Response
    {
        $referer = $this->requestStack->getCurrentRequest()->headers->get('referer');
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');
        $form = $this->createForm(Annonce::class, $posting, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $posting = $form->getData();
            $this->em->persist($posting);
            $this->em->flush();

            return $this->redirectToRoute('app_dashboard_company_posting_all', []);
        }

        return $this->render('dashboard/company/posting/edit.html.twig', [
            'referer' => $referer,
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/dashboard/company/posting/new', name: 'app_dashboard_company_posting_new')]
    public function postingNew(Request $request): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');

        $posting = $this->postingManager->init($company);
        $form = $this->createForm(Annonce::class, $posting, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $posting = $form->getData();
            $this->em->persist($posting);
            $this->em->flush();

            return $this->redirectToRoute('app_dashboard_company_posting_all', []);
        }

        return $this->render('dashboard/company/posting/new.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/dashboard/company/posting/all', name: 'app_dashboard_company_posting_all')]
    public function postingAll(): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/posting/all.html.twig', [
            'company' => $company,
            'postings' => $company->getPostings(),
            'experts' => $this->expertManager->candidate($company),
            'expertsDefault' => $this->identityRepository->findSearch(),
            'expertsAll' => $this->identityRepository->findAll(),
        ]);
    }
    
    #[Route('/dashboard/company/profile', name: 'app_dashboard_company_profile')]
    public function profile(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(ExpertSearchType::class);
        $form->handleRequest($request);
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');
        $experts = $this->expertManager->allExpert();
        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->get('query')->getData();
            $experts = $this->searchExperts($searchTerm, $entityManagerInterface);
        }

        return $this->render('dashboard/company/profile/index.html.twig', [
            'company' => $company,
            'expertsDefault' => $this->expertManager->allExpert(),
            'form' => $form->createView(),
            'experts' => $experts,
            'expertsAll' => $this->identityRepository->findSearch(),
        ]);
    }
    
    #[Route('/dashboard/company/message', name: 'app_dashboard_company_message')]
    public function message(): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/message/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/notification', name: 'app_dashboard_company_notification')]
    public function notification(): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');

        return $this->render('dashboard/company/notification/index.html.twig', [
            'company' => $company,
        ]);
    }
    
    #[Route('/dashboard/company/account', name: 'app_dashboard_company_account')]
    public function account(Request $request): Response
    {
        $company = $this->getCompanyOrRedirect();
        if (!$company) return $this->redirectToRoute('app_identity_create');
        $form = $this->createForm(CompanyType::class, $company, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData();
            $this->em->persist($company);
            $this->em->flush();
            $this->addFlash('success', "Votre compte a été mis à jour");

            return $this->redirectToRoute('app_dashboard_company', []);
        }

        return $this->render('dashboard/company/account/index.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    private function searchExperts(string $query, EntityManagerInterface $entityManager): array
    {
        $qb = $entityManager->createQueryBuilder();
        
        $keywords = array_filter(explode(' ', $query));
        $parameters = [];
    
        $conditions = [];
        foreach ($keywords as $key => $keyword) {
            $conditions[] = '(e.title LIKE :query' . $key . 
                            ' OR e.mainSkills LIKE :query' . $key . 
                            ' OR e.aspiration LIKE :query' . $key . 
                            ' OR e.preference LIKE :query' . $key . 
                            ' OR jt.name LIKE :query' . $key . 
                            ' OR tj.name LIKE :query' . $key . ')';
            $parameters['query' . $key] = '%' . $keyword . '%';
        }
    
        $qb->select('e')
            ->from('App\Entity\Expert', 'e')
            ->leftJoin('e.jobTypes', 'jt')
            ->leftJoin('e.typeJob', 'tj')
            ->where(implode(' OR ', $conditions))
            ->setParameters($parameters);
    
        return $qb->getQuery()->getResult();
    }
}
