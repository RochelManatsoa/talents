<?php

namespace App\Components\Carousel;

use App\Repository\PostingRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('carousel_posting_component')]
class PostingComponent
{

    public function __construct(
        private PostingRepository $postingRepository
    ){
    }

    public function getAllPostings(): array
    {
        return $this->postingRepository->findAll();
    }
}