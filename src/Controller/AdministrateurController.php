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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{
    /*
         block de code qui permet de faire la gestion du site
        -recherche des infos en base de donneeq
        - affichages des infos dans la vue
   */

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

    /*
       block de code qui permet de changer la categorie du mois
      -reception des donnees
      - mise a jour de la table
      - redirection vers le profil de l administrateur
 */

    /**
     * @Route("/administrateur/{catId}/{userId}", name="updateChoixCategorie" , methods="POST")
     */
    public function updateChoice($catId,$userId,EntityManagerInterface $entityManager,Request $request): Response
    {
        $action = $request->request->all();

        $categorie = $entityManager->getRepository(Categorie::class);

        $maCourante = $categorie-> findCategorieChoisie();

        $categorieChoisie = $categorie-> find($catId);

        $maCourante[0]->setMisEnAvant(0);

        $categorieChoisie->setMisEnAvant(1);

        $entityManager->flush();

      return $this->redirectToRoute('administrateurPage',['id'=>$userId]);
    }

    /*
       block de code qui permet de valider  la categorie ajouté a une prestataire
      -reception des donnees
      - mise a jour de la table
      - redirection vers le profil de l'administrateur
 */

    /**
     * @Route("/admin/{catId}/{userId}", name="validerCategorie" , methods="POST")
     */
    public function validerCategorie($catId,$userId,EntityManagerInterface $entityManager,Request $request): Response
    {
        $action = $request->request->all();


        $categorie = $entityManager->getRepository(Categorie::class);

        $laCategorie = $categorie->find($catId);

        $laCategorie->setValidation(1);


        $entityManager->flush();

        return $this->redirectToRoute('administrateurPage',['id'=>$userId]);
    }
}
