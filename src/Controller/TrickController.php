<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrickController extends AbstractController
{

    public function __construct(
        private TrickRepository $trickRepository,
    )
    {
    }

    #[Route('/tricks/{slug}', name: 'app_trick_show')]
    public function show(string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

        if (!$trick) {
            throw $this->createNotFoundException();
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }


}
