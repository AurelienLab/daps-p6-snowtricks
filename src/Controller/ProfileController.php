<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Form\UpdatePasswordFormType;
use App\Service\FileResolver;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FileUploader           $fileUploader,
        private readonly FileResolver           $fileResolver
    )
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/profile', name: 'app_profile')]
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
        }

        return $this->render('profile/edit.html.twig', [
            'profileForm' => $profileForm->createView(),
            'passwordForm' => $passwordUpdateForm->createView()
        ]);
    }


}
