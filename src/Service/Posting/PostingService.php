<?php

namespace App\Service\Posting;

use App\Entity\Posting;
use App\Repository\IdentityRepository;
use App\Repository\PostingRepository;
use App\Repository\UserRepository;
use App\Service\User\UserService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class PostingService
{
    public function __construct(
        private Security $security,
        private UserService $userService,
        private UserRepository $userRepository,
        private PostingRepository $postingRepository,
        private RequestStack $requestStack,
    ){
    }

    public function add(int $id): void
    {
        $posting = $this->requestStack->getSession()->get('posting', []);
        $posting[$id] =  1;

        $this->requestStack->getSession()->set('posting', $posting);
    }

    public function remove(int $id): void
    {
        $posting = $this->requestStack->getSession()->get('posting', []);
        if(!empty($posting[$id])){
            unset($posting[$id]);
        }

        $this->requestStack->getSession()->set('posting', $posting);
    }

    public function getPostingSession():array
    {
        $postings = [];
        $postingSession = $this->requestStack->getSession()->get('posting', []);
        foreach ($postingSession as $key => $value) {
           $postings[] =  $this->postingRepository->find($key);
        }

        return $postings;
    }

    public function storePreviousURL()
    {
        $previousRequest = $this->requestStack->getParentRequest();

        if ($previousRequest) {
            $this->requestStack->getSession()->set('original_uri_before_registration', $previousRequest->getUri());
        }
    }
}