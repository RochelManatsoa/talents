<?php

namespace App\Components\Carousel;

use App\Entity\Identity;
use App\Repository\ExpertRepository;
use App\Service\User\UserService;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('carousel_expert_component')]
class ExpertComponent
{

    public function __construct(
        private ExpertRepository $expertRepository,
        private UserService $userService,
    ){
    }

    public function getAllExperts(): array
    {
        return $this->expertRepository->findValidExperts();
    }

    public function getIdentity(): Identity
    {
        return $this->userService->getCurrentIdentity();
    }
}