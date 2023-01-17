<?php

namespace App\Controller;

use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    // route de redirection de la composante recher
    /**
     * @Route("/rechercher", name="search")
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

// to do : recuperer le mot saisi dans le formulaire
        // traiter la rechercher et afficher les resultats vers une route a creer
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        return $this->redirectToRoute('pageAccueil', [
            'form' => $form
        ]);
    }
}
