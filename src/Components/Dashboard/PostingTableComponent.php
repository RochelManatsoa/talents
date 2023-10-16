<?php

namespace App\Components\Dashboard;

use App\Entity\Identity;
use App\Entity\Posting;
use App\Form\ApplicationType;
use App\Manager\PostingManager;
use App\Repository\PostingRepository;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsTwigComponent('table_posting_component')]
class PostingTableComponent extends AbstractController
{
    public string $type = 'success';
    public string $message;
    public int $id;

    public function __construct(
        private PostingRepository $postingRepository,
        private PostingManager $postingManager,
        private RequestStack $requestStack,
        private UserService $userService,
    ){
    }

    public function getPosting(): Posting
    {
        return $this->postingRepository->find($this->id);
    }

    public function getForm(): FormView
    {
        $posting = $this->postingRepository->find($this->id);
        $application = $this->postingManager->postuler($posting);
        $form = $this->createForm(ApplicationType::class, $application, []);

        return $form->createView();
    }

    public function getIdentity(): Identity
    {
        return $this->userService->getCurrentIdentity();
    }
}