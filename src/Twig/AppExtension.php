<?php

namespace App\Twig;

use App\Repository\AccountRepository;
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
        )
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('meta_title', [$this, 'metaTitle']),
            new TwigFunction('meta_description', [$this, 'metaDescription']),
            new TwigFunction('meta_keywords', [$this, 'metaKeywords']),
            new TwigFunction('show_account_desc', [$this, 'showAccountDesc']),
        ];
    }

    public function metaTitle(): string
    {
        $routeName = $this->requestStack->getCurrentRequest()->attributes->get('_route'); 

        return $this->translator->trans($routeName . '.title');
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

    public function showAccountDesc(int $accountId)
    {
        return $this->accountRepository->findOneById($accountId)->getDescription();
    }
}