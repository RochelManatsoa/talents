<?php

namespace App\Twig;

use App\Repository\AccountRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private RequestStack $requestStack,
        private TranslatorInterface $translator,
        private AccountRepository $accountRepository,
        private Security $security,
        )
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('meta_title', [$this, 'metaTitle']),
            new TwigFunction('dashboard_title', [$this, 'dashboardTitle']),
            new TwigFunction('meta_description', [$this, 'metaDescription']),
            new TwigFunction('meta_keywords', [$this, 'metaKeywords']),
            new TwigFunction('show_account_desc', [$this, 'showAccountDesc']),
            new TwigFunction('isoToEmoji', [$this, 'isoToEmoji']),
            new TwigFunction('show_country', [$this, 'showCountry']),
            new TwigFunction('experience_text', [$this, 'getExperienceText'])
        ];
    }

    public function metaTitle(): string
    {
        $routeName = $this->requestStack->getCurrentRequest()->attributes->get('_route'); 

        return $this->translator->trans($routeName . '.title');
    }

    public function dashboardTitle(): string
    {
        $routeName = $this->requestStack->getCurrentRequest()->attributes->get('_route'); 
        $user = $this->security->getUser();
        $companyName = $user->getIdentity()->getCompany()->getName();

        return $this->translator->trans($routeName . '.dashboard_title', ['%company_name%' => $companyName]);
    }

    public function metaDescription(): string
    {
        $routeName = $this->requestStack->getCurrentRequest()->attributes->get('_route'); 
        return $this->translator->trans($routeName . '.description');
    }

    public function metaKeywords(): string
    {
        $routeName = $this->requestStack->getCurrentRequest()->attributes->get('_route');  
        return $this->translator->trans($routeName . '.keywords');
    }

    public function showAccountDesc($accountId)
    {
        $accountId = (int) $accountId;
        $account = $this->accountRepository->findOneById($accountId);
        // dd($account, $account->getDescription());
        return $account;
    }

    public function isoToEmoji(string $code)
    {
        return implode(
            '',
            array_map(
                fn ($letter) => mb_chr(ord($letter) % 32 + 0x1F1E5),
                str_split($code)
            )
        );
    }

    public function showCountry($countryCode)
    {
        if(null !== $countryCode){
            return \Symfony\Component\Intl\Countries::getName($countryCode);
        }
        return null;
    }

    public function getExperienceText(string $value): string
    {
        $choices = [
            'SM' => '1 an',
            'MD' => '1-3 ans',
            'LG' => '3-5 ans',
            'XL' => '+ de 5 ans', // J'ai modifié la clé ici de 'LG' à 'XL' car 'LG' était dupliqué
        ];

        return $choices[$value] ?? 'N/A';
    }
}