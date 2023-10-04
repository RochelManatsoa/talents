<?php

namespace App\Manager;

use App\Entity\Company;
use App\Repository\AccountRepository;
use App\Repository\ExpertRepository;
use App\Repository\IdentityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;

class ExpertManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private SluggerInterface $sluggerInterface,
        private AccountRepository $accountRepository,
        private RequestStack $requestStack,
        private ExpertRepository $expertRepository,
        private IdentityRepository $identityRepository,
        private Security $security
    ){}

    public function allExpert(): array
    {
        return $this->identityRepository->findSearch();
    }
    
    public function likedByCompany(Company $company): array
    {
        $postings = $company->getPostings();

        $postingsOk = [];
        $postingsFail = [];

        foreach ($postings as $posting) {
            if ($posting->isIsValid()) {
                $postingsOk[] = $posting;
            } else {
                $postingsFail[] = $posting;
            }
        }

        return [$postingsOk, $postingsFail];
    }
}
