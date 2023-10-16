<?php

namespace App\Components\Search;

use App\Repository\PostingRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('posting_search_component')]
class PostingSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private PostingRepository $postingRepository
    ){
    }

    public function getPostings(): array
    {
        return $this->postingRepository->findByQuery($this->query);
    }
}