<?php

namespace App\Components;

use App\Entity\Posting;
use App\Repository\PostingRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('posting_component')]
class PostingComponent
{
    public string $type = 'success';
    public string $message;
    public int $id;

    public function __construct(
        private PostingRepository $postingRepository
    ){
    }

    public function getPosting(): Posting
    {
        return $this->postingRepository->find($this->id);
    }
}