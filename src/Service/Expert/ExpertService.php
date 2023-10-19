<?php

namespace App\Service\Expert;

use App\Entity\Expert;
use App\Repository\IdentityRepository;
use App\Repository\ExpertRepository;
use App\Repository\UserRepository;
use App\Service\User\UserService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class ExpertService
{
    public function __construct(
        private Security $security,
        private UserService $userService,
        private UserRepository $userRepository,
        private ExpertRepository $expertRepository,
        private RequestStack $requestStack,
    ){
    }

    public function add(int $id): void
    {
        $expert = $this->requestStack->getSession()->get('expert', []);
        $expert[$id] =  1;

        $this->requestStack->getSession()->set('expert', $expert);
    }

    public function remove(int $id): void
    {
        $expert = $this->requestStack->getSession()->get('expert', []);
        if(!empty($expert[$id])){
            unset($expert[$id]);
        }

        $this->requestStack->getSession()->set('expert', $expert);
    }

    public function getExpertSession():array
    {
        $experts = [];
        $expertSession = $this->requestStack->getSession()->get('expert', []);
        foreach ($expertSession as $key => $value) {
           $experts[] =  $this->expertRepository->find($key);
        }

        return $experts;
    }
}