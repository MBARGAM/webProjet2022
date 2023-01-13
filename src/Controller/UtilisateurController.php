<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/inscription/{typeInscription}", name="signin")
     */


    public function index($typeInscription): Response
    {

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    /**
     * @Route("/redirection", name="mobileSignup")
     */

    public function reidrectionMobile(): Response
    {
        return $this->render('utilisateur/pageRedirectionMobile.html.twig');
    }
}
