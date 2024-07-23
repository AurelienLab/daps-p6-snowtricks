<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Form\UpdatePasswordFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface      $entityManager,
        private readonly FileUploader                $fileUploader,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }


    /**
     * Profile and password update form page
     *
     * @throws Exception
     */
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function editAction(Request $request)
    {
        $profileForm = $this->createForm(ProfileFormType::class, $this->getUser());
        $passwordUpdateForm = $this->createForm(UpdatePasswordFormType::class, $this->getUser());

        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {

            // Upload profile picture if exists
            $profilePicture = $profileForm->get('profilePictureFile')->getData();
            if (!empty($profilePicture)) {
                $this->fileUploader->upload($profilePicture, $this->getUser(), 'user_profile');
            }

            $this->entityManager->flush();

            $this->addFlash('success', 'snowtricks.flashes.profile_updated');
        }

        $passwordUpdateForm->handleRequest($request);

        if ($passwordUpdateForm->isSubmitted() && $passwordUpdateForm->isValid()) {
            $encodedPassword = $this->passwordHasher->hashPassword(
                $this->getUser(),
                $passwordUpdateForm->get('plainPassword')->getData()
            );

            $this->getUser()->setPassword($encodedPassword);
            $this->entityManager->flush();

            $this->addFlash('success', 'snowtricks.flashes.password_updated');
        }

        return $this->render(
            'profile/edit.html.twig',
            [
                'profileForm' => $profileForm->createView(),
                'passwordForm' => $passwordUpdateForm->createView(),
                'pageTitle' => 'Mon profil'
            ]);
    }


}
