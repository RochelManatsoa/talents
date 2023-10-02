<?php

namespace App\Service\User;

use App\Entity\Identity;
use App\Repository\IdentityRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;

class UserService
{
    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
        private IdentityRepository $identityRepository,
    ){
    }

    public function getCurrentUser()
    {
        return $this->security->getUser();
    }

    public function getCurrentIdentity(): ?Identity
    {
        return $this->identityRepository->findOneBy(['user' => $this->security->getUser()]);
    }
}