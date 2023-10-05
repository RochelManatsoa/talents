<?php

namespace App\Controller\Ajax;

use App\Entity\Posting;
use App\Repository\PostingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostingController extends AbstractController
{
    public function __construct(
        private PostingRepository $postingRepository,
        private EntityManagerInterface $entityManager,
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
}
