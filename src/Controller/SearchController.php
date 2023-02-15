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
     * @Route("/rechercher/{idCategorie}/{idLocalite}/{idCommune}/{idCp}/{nomPrestataire}", name="search")
     */
    public function index($idCategorie,$idLocalite,$idCommune,$idCp,$nomPrestataire,Request $request,EntityManagerInterface $entityManager): Response
    {
          $data = [
            'idCategorie' => $idCategorie,
            'idLocalite' => $idLocalite,
            'idCommune' => $idCommune,
            'idCp' => $idCp,
            'nomPrestataire' => $nomPrestataire];

          dd($data);

        return $this->redirectToRoute('pageAccueil', [
            'form' => $form
        ]);
    }
}
