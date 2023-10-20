<?php

namespace App\Components\Carousel;

use App\Entity\Identity;
use App\Repository\ExpertRepository;
use App\Repository\IdentityRepository;
use App\Service\User\UserService;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('carousel_expert_top')]
class ExpertComponentTop
{

    public function __construct(
        private ExpertRepository $expertRepository,
        private UserService $userService,
        private IdentityRepository $identityRepository
    ){
    }

    public function getAllExperts(): array
    {
        return $this->expertRepository->findValidExperts();
    }

    public function getTopRanked(): array
    {
        return $this->identityRepository->findTopRanked();
    }

    public function getIdentity(): Identity
    {
        return $this->userService->getCurrentIdentity();
    }
}