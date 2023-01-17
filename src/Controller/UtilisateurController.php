<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{

    //route permettant d authentifier un utilisateur internaute ou prestataire
    /**
     * @Route("/inscription/{typeInscription}", name="signin")
     */

    public function index($typeInscription): Response
    {

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /*route permettant de rediriger un nouvel utiliateur vers le choix du type d inscription en version mobile
    car en version tablette et pc , nous avons une modal*/

    /**
     * @Route("/redirection", name="mobileSignup")
     */

    public function reidrectionMobile(): Response
    {
        return $this->render('utilisateur/pageRedirectionMobile.html.twig');
    }
}
