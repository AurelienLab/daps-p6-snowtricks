<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrickController extends AbstractController
{

    #[Route('/tricks/slug')]
    public function show(): Response
    {
        return $this->render('trick/show.html.twig');
    }


}
