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
    /**
     * @Route("/rechercher", name="search")
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        return $this->redirectToRoute('pageAccueil', [
            'form' => $form
        ]);
    }
}
