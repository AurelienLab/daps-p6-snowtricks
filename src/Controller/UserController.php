<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    #[Route('/users', name: 'app_user')]
    public function index(): Response
    {
        $users = $this->userRepository->findBy([], ['name' => 'ASC']);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
