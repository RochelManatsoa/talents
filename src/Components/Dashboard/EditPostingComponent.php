<?php

namespace App\Components\Dashboard;

use App\Entity\Posting;
use App\Entity\Identity;
use App\Form\ApplicationType;
use App\Manager\PostingManager;
use App\Service\User\UserService;
use Symfony\Component\Form\FormView;
use App\Repository\PostingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsTwigComponent('edit_posting_component')]
class EditPostingComponent extends AbstractController
{
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[LiveProp(exposed: ['title', 'type', 'sector', 'description', 'tarif', 'number', 'plannedDate'])]    
    #[Assert\Valid]

    public Posting $posting;
    public string $type = 'success';
    public bool $isSaved = false;

    public function __construct(
        private PostingRepository $postingRepository,
        private PostingManager $postingManager,
        private RequestStack $requestStack,
        private UserService $userService,
    ){
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        $this->validate();

        $this->isSaved = true;
        $entityManager->flush();
    }
}