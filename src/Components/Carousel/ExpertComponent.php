<?php

namespace App\Components\Carousel;

use App\Repository\ExpertRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('carousel_expert_component')]
class ExpertComponent
{

    public function __construct(
        private ExpertRepository $expertRepository
    ){
    }

    public function getAllExperts(): array
    {
        return $this->expertRepository->findAll();
    }
}