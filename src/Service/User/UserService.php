<?php

namespace App\Service\User;

use App\Entity\Identity;
use App\Repository\IdentityRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class UserService
{
    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
        private IdentityRepository $identityRepository,
        private RequestStack $requestStack,
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

    public function storeCurrentURI()
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        
        // dd($currentRequest);
        // Si la requête actuelle est la page de connexion
        if ($currentRequest && $currentRequest->getPathInfo() == '/login') { 
            // Obtenez la requête parente (précédente)
            $parentRequest = $this->requestStack->getParentRequest();
        }
            
        if ($parentRequest) {
            $uri = $parentRequest->getUri();
            $this->requestStack->getSession()->set('redirect_uri_after_registration', $uri);
        }
    }

    public function getStoredURI(): ?string
    {
        return $this->requestStack->getSession()->get('redirect_uri_after_registration');
    }

    public function removeStoredURI(string $string)
    {
        return $this->requestStack->getSession()->remove($string);
    }

}