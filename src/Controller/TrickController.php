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
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TrickController extends AbstractController
{

    public const PAGINATOR_TRICKS_PER_PAGE = 3;


    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickRepository        $trickRepository,
        private readonly CommentRepository      $commentRepository,
        private readonly FileUploader           $fileUploader
    )
    {
    }


    /**
     * Returns a json with pagination information and html of the tricks cards
     * Used for ajax pagination in tricks list
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/ajax/tricks', name: 'app_ajax_trick_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $tricks = new Paginator($this->trickRepository->findAllQuery(), $request);
        $tricks->perPage(self::PAGINATOR_TRICKS_PER_PAGE);

        return new JsonResponse(
            [
                'paginator' => [
                    'is_last_page' => $tricks->isLastPage(),
                    'next_page_url' => $tricks->next()
                ],
                'content' => $this->renderView('trick/_index-ajax.html.twig', compact('tricks'))
            ]);
    }


    /**
     * Trick details page
     *
     * @param Request $request
     * @param string $slug
     * @return Response
     */
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

        return $this->render(
            'trick/show.html.twig', [
            'trick' => $trick,
            'commentForm' => $commentForm?->createView(),
            'comments' => $comments,
            'pageTitle' => $trick->getName()
        ]);
    }


    /**
     * Trick edit page
     *
     * @param Request $request
     * @param Trick $trick
     * @return Response
     * @throws Exception
     */
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

        return $this->render(
            'trick/edit.html.twig',
            [
                'trick' => $trick,
                'form' => $form->createView(),
                'pageTitle' => 'Editer ' . $trick->getName(),
            ]);
    }


    /**
     * Add a new trick
     *
     * @param Request $request
     * @return Response
     * @throws Exception
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

        return $this->render(
            'trick/edit.html.twig',
            [
                'trick' => $trick,
                'form' => $form->createView(),
                'pageTitle' => 'Nouveau trick'
            ]);
    }


    /**
     * Delete a trick (confirmation asked by modal before)
     *
     * @param Request $request
     * @return Response
     */
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
