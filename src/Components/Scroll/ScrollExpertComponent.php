<?php

namespace App\Components\Scroll;

use App\Repository\ExpertRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('scroll_expert_component')]
class ScrollExpertComponent
{
    public array $experts;
}