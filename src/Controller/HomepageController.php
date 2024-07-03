<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_homepage')]
    public function index()
    {
        $tricks = $this->entityManager->getRepository(Trick::class)->findAll();

        return $this->render('homepage/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
