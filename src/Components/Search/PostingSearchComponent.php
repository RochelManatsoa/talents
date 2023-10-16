<?php

namespace App\Components\Search;

use App\Entity\Identity;
use App\Manager\PostingManager;
use App\Service\User\UserService;
use App\Repository\PostingRepository;
use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('posting_search_component')]
class PostingSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private PostingRepository $postingRepository,
        private ApplicationRepository $applicationRepository,
        private PostingManager $postingManager,
        private RequestStack $requestStack,
        private UserService $userService,
    ) {
    }

    public function getPostings(): array
    {
        return $this->postingRepository->findByQuery($this->query);
    }

    public function getIdentity(): Identity
    {
        return $this->userService->getCurrentIdentity();
    }

    public function getIdentityApplications(): Collection
    {
        return $this->getIdentity()->getApplications();
    }
}
