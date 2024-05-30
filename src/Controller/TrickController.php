<?php

namespace App\Controller;

use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrickController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private TrickRepository        $trickRepository,
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

    #[Route('/tricks/{slug}/edit', name: 'app_trick_edit')]
    public function edit(Request $request, string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

        if (!$trick) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            
            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }


}
