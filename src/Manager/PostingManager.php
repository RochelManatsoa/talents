<?php

namespace App\Manager;

use App\Entity\Company;
use App\Entity\Posting;
use App\Repository\AccountRepository;
use App\Repository\IdentityRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;

class PostingManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private SluggerInterface $sluggerInterface,
        private AccountRepository $accountRepository,
        private RequestStack $requestStack,
        private IdentityRepository $identityRepository,
        private Security $security
    ){}

    public function init(Company $company): Posting
    {
        $posting = new Posting();
        $posting
            ->setCreatedAt(new DateTime())
            ->setJobId(new Uuid(Uuid::v1()))
            ->setCompany($company)
            ->setIsValid(false)
            ;

        return $posting;
    }
    
    public function splitPostingsByValidity(Company $company): array
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
