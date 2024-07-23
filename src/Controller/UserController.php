<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository         $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly FileUploader           $fileUploader
    )
    {
    }


    /**
     * List of users (for adin only)
     *
     * @return Response
     */
    #[Route('/users', name: 'app_user')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        $users = $this->userRepository->findBy([], ['name' => 'ASC']);

        return $this->render(
            'user/index.html.twig',
            [
                'users' => $users,
                'pageTitle' => 'Utilisateurs'
            ]
        );
    }


    /**
     * Edit a user (admin only)
     *
     * @param User $user
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    #[Route('/user/{id}', name: 'app_user_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles([$form->get('roles')->getData()]);

            // Upload profile picture if exists
            $profilePicture = $form->get('profilePictureFile')->getData();
            if (!empty($profilePicture)) {
                $this->fileUploader->upload($profilePicture, $this->getUser(), 'user_profile');
            }

            $this->entityManager->flush();
            $this->addFlash('success', 'snowtricks.flashes.user_updated');
        }

        return $this->render(
            'user/edit.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
                'pageTitle' => 'Editer ' . $user->getName()
            ]
        );
    }


}
