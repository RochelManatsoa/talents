<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\Posting\PostingService;
use App\Service\User\UserService;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegistrationController extends AbstractController
{

    public function __construct(
        private EmailVerifier $emailVerifier,
        private PostingService $postingService,
        private UserService $userService,
        private RequestStack $requestStack
    ){
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, MailerInterface $mailer, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        dump($this->requestStack->getCurrentRequest()->getSession()->get('_security.main.target_path'));
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('support@olona-talents.com', 'Olona Talents'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository, TokenStorageInterface $tokenStorage): Response
    {
        dump($this->postingService->getPostingSession());
        dump($this->requestStack->getCurrentRequest()->getSession()->get('_security.main.target_path'));
        $id = $request->query->get('id');
        $originalURI = $this->userService->getStoredURI();
    
        if ($originalURI) {
            $this->userService->removeStoredURI('original_uri_before_registration');
            return $this->redirect($originalURI);
        }

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // Connecter l'utilisateur après la vérification de l'e-mail
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $tokenStorage->setToken($token);

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        $request = $this->requestStack->getCurrentRequest();
        if ($request) {
            $session = $request->getSession();
            $targetPath = $session->get('_security.main.target_path');
        }
        $redirectURI = $this->userService->getStoredURI();
        if ($redirectURI) {
            $this->userService->storeCurrentURI(null); // ou $this->session->remove('redirect_uri_after_registration');
            return $this->redirect($redirectURI);
        }
        // dd($this->requestStack->getCurrentRequest()->getSession()->get('_security.main.target_path'));
        return $this->redirectToRoute('app_connect');
    }
}
