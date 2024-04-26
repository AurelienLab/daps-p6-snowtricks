<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Form\UpdatePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'app_profile')]
    public function editAction()
    {
        $profileForm = $this->createForm(ProfileFormType::class, $this->getUser());
        $passwordUpdateForm = $this->createForm(UpdatePasswordFormType::class, $this->getUser());
        return $this->render('profile/edit.html.twig', [
            'profileForm' => $profileForm->createView(),
            'passwordForm' => $passwordUpdateForm->createView()
        ]);
    }


}
