<?php

namespace App\Controller\Dashboard;

use DateTime;
use App\Entity\Expert;
use App\Entity\Posting;
use App\Manager\PostingManager;
use App\Service\User\UserService;
use App\Form\Search\PostingSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private EntityManagerInterface $em,
        private PostingManager $postingManager
    ){
    }

    #[Route('/dashboard/expert', name: 'app_dashboard_expert')]
    public function index(Request $request): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        $now = new DateTime();

        $monday = clone $now;
        $monday->modify('this monday');
        $sunday = clone $monday;
        $sunday->modify('+6 days');

        $formatMonday = $monday->format('d');
        $formatSunday = $sunday->format('d F Y');

        $form = $this->createForm(PostingSearchType::class);
        $form->handleRequest($request);

        return $this->render('dashboard/expert/index.html.twig', [
            'identity' => $identity,
            'postings' => $this->postingManager->findExpertAnnouncements($expert),
            'formatMonday' => $formatMonday,
            'formatSunday' => $formatSunday,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/expert/posting', name: 'app_dashboard_expert_posting')]
    public function posting(Request $request): Response
    {
        $identity = $this->userService->getCurrentIdentity();
        $expert = $identity->getExpert();
        if(!$expert instanceof Expert) return $this->redirectToRoute('app_identity_create');
        
        $form = $this->createForm(PostingSearchType::class);
        $form->handleRequest($request);
        $postings = $this->postingManager->allPosting();
        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->get('query')->getData();
            $postings = $this->searchPostings($searchTerm, $this->em);
        }

        return $this->render('dashboard/expert/posting/index.html.twig', [
            'identity' => $identity,
            'form' => $form->createView(),
            'postings' => $postings,
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

    private function searchPostings(string $query, EntityManagerInterface $entityManager): array
    {
        $qb = $entityManager->createQueryBuilder();
        
        $keywords = array_filter(explode(' ', $query));
        $parameters = [];
    
        $conditions = [];
        foreach ($keywords as $key => $keyword) {
            $conditions[] = '(p.title LIKE :query' . $key . 
                            ' OR p.description LIKE :query' . $key . 
                            ' OR sec.name LIKE :query' . $key . 
                            ' OR lang.name LIKE :query' . $key . 
                            ' OR ts.name LIKE :query' . $key . ')';
            $parameters['query' . $key] = '%' . $keyword . '%';
        }
    
        $qb->select('p')
            ->from('App\Entity\Posting', 'p')
            ->leftJoin('p.sector', 'sec')
            ->leftJoin('p.technicalSkills', 'ts')
            ->leftJoin('p.languages', 'lang')
            ->where(implode(' OR ', $conditions))
            ->andWhere('p.status = :status')
            ->setParameters(array_merge($parameters, ['status' => Posting::STATUS_PUBLISHED]));
    
        return $qb->getQuery()->getResult();
    }
}
