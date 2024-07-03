<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentFormType;
use App\Form\TrickFormType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use App\Service\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TrickController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickRepository        $trickRepository,
        private readonly CommentRepository      $commentRepository,
        private readonly FileUploader           $fileUploader
    )
    {
    }

    #[Route('/tricks/{slug}', name: 'app_trick_show')]
    public function show(Request $request, string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

        if (!$trick) {
            throw $this->createNotFoundException();
        }

        $commentForm = null;

        if ($this->getUser() !== null) {
            $comment = new Comment();
            $commentForm = $this->createForm(CommentFormType::class, $comment);

            $commentForm->handleRequest($request);

            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $comment
                    ->setTrick($trick)
                    ->setAuthor($this->getUser())
                ;
                $this->entityManager->persist($comment);
                $this->entityManager->flush();

                $this->addFlash('success', 'snowtricks.flashes.comment_created');

                return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()]);
            }

        }

        $comments = new Paginator($this->commentRepository->getCommentPaginatorQuery($trick), $request);
        $comments
            ->perPage(6)
        ;

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'commentForm' => $commentForm?->createView(),
            'comments' => $comments
        ]);
    }

    #[Route('/tricks/{slug}/edit', name: 'app_trick_edit')]
    #[IsGranted('edit', 'trick')]
    public function edit(Request $request, Trick $trick): Response
    {
        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload featured picture if exists
            $featuredPicture = $form->get('featuredPictureFile')->getData();
            if (!empty($featuredPicture)) {
                $this->fileUploader->upload($featuredPicture, $trick, 'trick_featured_picture');
            }

            $this->entityManager->flush();

            $this->addFlash('success', 'snowtricks.flashes.trick_updated');

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'snowtricks.flashes.form_errors');
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws ORMException
     */
    #[Route('/tricks/create', name: 'app_trick_create', priority: 20)]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload featured picture if exists
            $featuredPicture = $form->get('featuredPictureFile')->getData();
            if (!empty($featuredPicture)) {
                $this->fileUploader->upload($featuredPicture, $trick, 'trick_featured_picture');
            }

            $trick->setAuthor($this->getUser());
            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            $this->addFlash('success', 'snowtricks.flashes.trick_created');

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'snowtricks.flashes.form_errors');
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/tricks/remove', name: 'app_trick_remove', methods: 'POST', priority: 20)]
    public function delete(Request $request): Response
    {
        $trickId = $request->getPayload()->get('trick_id');

        $trick = $this->trickRepository->findOneBy(['id' => $trickId]);

        $this->denyAccessUnlessGranted('delete', $trick);

        if (!$trick) {
            throw $this->createNotFoundException();
        }

        $this->entityManager->remove($trick);
        $this->entityManager->flush();

        $this->addFlash('success', 'snowtricks.flashes.trick_removed');

        return $this->redirectToRoute('app_homepage', ['_fragment' => 'tricks']);
    }
}
