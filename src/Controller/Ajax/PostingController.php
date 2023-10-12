<?php

namespace App\Controller\Ajax;

use App\Entity\Posting;
use App\Form\ApplicationType;
use App\Manager\PostingManager;
use App\Repository\PostingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostingController extends AbstractController
{
    public function __construct(
        private PostingRepository $postingRepository,
        private EntityManagerInterface $entityManager,
        private PostingManager $postingManager,
    ){
    }

    #[Route('/ajax/{jobId}/delete', name: 'app_ajax_posting_delete')]
    public function index(Posting $posting): Response
    {
        $this->entityManager->remove($posting);
        $this->entityManager->flush();

        return $this->json([
            'message' => "Posting deleted"
        ], 200, [], []);
    }

    #[Route('/ajax/apply/{jobId}', name: 'app_ajax_posting_apply', methods: ["POST"])]
    public function apply(Request $request, Posting $posting): Response
    {
        $application = $this->postingManager->postuler($posting);
        $form = $this->createForm(ApplicationType::class, $application, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postingManager->saveApplication($form->getData());

            return $this->json([
                'message' => "Candidature envoyé"
            ], 200, [], []);
        }

        return $this->json([
            'message' => "Erreur lors de l\'envoi de la candidature"
        ], 200, [], []);
    }
}
