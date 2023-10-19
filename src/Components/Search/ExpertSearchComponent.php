<?php

namespace App\Components\Search;

use App\Entity\Identity;
use App\Manager\PostingManager;
use App\Service\User\UserService;
use App\Repository\ApplicationRepository;
use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('expert_search_component')]
class ExpertSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private ExpertRepository $expertRepository,
        private ApplicationRepository $applicationRepository,
        private PostingManager $postingManager,
        private RequestStack $requestStack,
        private UserService $userService,
    ) {
    }

    public function getExperts(): array
    {
        return $this->expertRepository->findByQuery($this->query);
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
