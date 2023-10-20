<?php

namespace App\Controller\Ajax;

use App\Repository\ExpertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpertController extends AbstractController
{
    #[Route('/ajax/expert', name: 'app_ajax_expert')]
    public function index(
        Request $request,
        ExpertRepository $expertRepository
    ): Response
    {
        $offset = $request->query->get('offset', 0);

        return $this->json([
            'html' => $this->renderView('components/scroll_expert_component.html.twig', [
                'experts' => $expertRepository->findTopExperts('', 10, $offset),
            ], []),
        ], 200, [], []);

        // return $this->json([
        //     'data' => $expertRepository->findTopExperts('', 10, $offset),
        // ], 200, [], ['groups' => 'identity']);
    }
}
