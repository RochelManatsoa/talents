<?php

namespace App\Controller;

use App\Entity\Expert;
use App\Entity\Account;
use App\Entity\Company;
use App\Entity\Identity;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_connect');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/connect', name: 'app_connect')]
    public function connect(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Identity $identity */
        $identity = $user->getIdentity();
        if(!$identity instanceof Identity) return $this->redirectToRoute('app_identity_create');
        if(!$identity->getAccount() instanceof Account) return $this->redirectToRoute('app_identity_create');
        if($identity->getCompany() instanceof Company) return $this->redirectToRoute('app_dashboard_company');
        if($identity->getExpert() instanceof Expert) return $this->redirectToRoute('app_dashboard_expert');

        return $this->redirectToRoute('app_identity_create');
    }
    
    #[Route(path: '/connect/google', name: 'connect_google_start')]
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google_main') 
            ->redirect();
    }

    #[Route(path: '/connect/google/check', name: 'connect_google_check')]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        if(!$this->getUser()){
            return new JsonResponse([
                'status' => false,
                'message' => "User not found"
            ]);
        }else{
            return $this->redirectToRoute('app_connect');
        }
    }
}
