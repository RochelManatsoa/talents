<?php

namespace App\Components\Dashboard;

use App\Entity\Expert;
use App\Repository\ExpertRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('dashboard_expert_component')]
class ExpertComponent
{
    public string $type = 'success';
    public string $message;
    public int $id;

    public function __construct(
        private ExpertRepository $expertRepository
    ){
    }

    public function getExpert(): Expert
    {
        return $this->expertRepository->find($this->id);
    }
}