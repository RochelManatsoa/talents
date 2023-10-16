<?php

namespace App\Components\Dashboard;

use App\Entity\Posting;
use App\Entity\Identity;
use App\Entity\Application;
use App\Entity\Company;
use App\Form\ApplicationType;
use App\Manager\PostingManager;
use App\Service\User\UserService;
use App\Repository\ApplicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsTwigComponent('table_application_component')]
class ApplicationTableComponent extends AbstractController
{
    public int $id;

    public function __construct(
        private ApplicationRepository $applicationRepository,
        private PostingManager $postingManager,
        private RequestStack $requestStack,
        private UserService $userService,
    ){
    }

    public function getApplication(): Application
    {
        return $this->applicationRepository->find($this->id);
    }

    public function getPosting(): Posting
    {
        return $this->getApplication()->getPosting();
    }

    public function getCompany(): Company
    {
        return $this->getPosting()->getCompany();
    }

    public function getIdentity(): Identity
    {
        return $this->userService->getCurrentIdentity();
    }

    public function getIdentityApplications(): array
    {
        return $this->getIdentity()->getApplications();
    }
}