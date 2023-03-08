<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\Internaute;
use App\Entity\Newsletter;
use App\Entity\Prestataire;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{
    /**
     * @Route("/administrateur/{id}", name="administrateurPage")
     */
    public function index($id,EntityManagerInterface $entityManager): Response
    {
        $admin = $entityManager->getRepository(Utilisateur::class);

        $admin = $admin->find($id);

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> AllCategorie();

        $internaute = $entityManager->getRepository(Internaute::class);

        $internautes = $internaute->findAllInternaute();

        $prestataire = $entityManager->getRepository(Prestataire::class);

        $prestataires = $prestataire->allPrestataires();

        $newsletter = $entityManager->getRepository(Newsletter::class);

        $newsletters = $newsletter->findAll();

        $commentaires = $entityManager->getRepository(Commentaire::class);

        $commentaires = $commentaires->findAll();

        $image = $entityManager->getRepository(Image::class);

        $images = $image->findAll();


        $data = [
            'categorie' => $listeCategorie,
            'internautes' => $internautes,
            'prestataires' => $prestataires,
            'newsletters' => $newsletters,
            'commentaires' => $commentaires,
            'images' => $images,
            'admin' => $admin,
        ];

        return $this->render('administrateur/index.html.twig', [
            'allDatas' => $data,
        ]);
    }
}
