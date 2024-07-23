<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Service\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }


    /**
     * Homepage Controller
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request)
    {
        $tricks = new Paginator(
            $this->entityManager->getRepository(Trick::class)->findAllQuery(),
            $request
        );
        $tricks
            ->perPage(TrickController::PAGINATOR_TRICKS_PER_PAGE)
            ->path($this->generateUrl('app_ajax_trick_index'))
        ;

        return $this->render(
            'homepage/index.html.twig',
            ['tricks' => $tricks]
        );
    }


}
