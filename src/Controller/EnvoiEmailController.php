<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnvoiEmailController extends AbstractController
{
    /**
     * @Route("/email", name="envoiemail")
     */
    public function index(): Response
    {
        return $this->render('envoi_email/index.html.twig', [
            'controller_name' => 'EnvoiEmailController',
        ]);
    }
}
