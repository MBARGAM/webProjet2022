<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Prestataire;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
  /* cette fonction recupere le tableau des prestataires recherchés , cree un tableau vide
  et boucle sur chaque entree tout en recherchant le logo de celui ci et reforme un tableau de resultats */
    static function resultats($tableau,EntityManagerInterface $entityManager)
    {
        $tabPrestataire=[];

        if ($tableau == null){

            return  $tabPrestataire;

        }else{

            foreach ($tableau as $key => $data){

                $req = $entityManager->getRepository(Image::class);

                $listeImage = $req->findPicName($data["id"]);

                if($listeImage != null){

                    $data["image"] = $listeImage[0]['nom'];

                    $tabPrestataire[] = $data;

                }else{
                    $data["image"]= 'pic.jpg';

                    $tabPrestataire[] = $data;

                }

            }
         }
        return $tabPrestataire;
    }

    // route de redirection de la composante recher
    /**
     * @Route("/rechercher/{idCategorie}/{idLocalite}/{idCommune}/{idCp}/{nomPrestataire}/{NoPage}", name="search")
     */

    public function index($idCategorie,$idLocalite,$idCommune,$idCp,$nomPrestataire,$NoPage,Request $request,EntityManagerInterface $entityManager): Response
    {

       //donnees recues du formulaire de recherche soumis en dehor de la page de recherche
        $data = [
            'idCategorie' => $idCategorie,

            'idLocalite' => $idLocalite,

            'idCommune' => $idCommune,

            'idCp' => $idCp,

            'nomPrestataire' => $nomPrestataire
        ];

        $requete = $entityManager->getRepository(Prestataire::class);

        $listePrestataire = $requete->findAllPrestataire($data,$page=$NoPage);

        //formulaire de recherche qui sera affiché en permanence
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire se trouvant sur la page du  est soumis et valide

            $data = $form->getData();

            $datas = $form->getData();

            $data = [
                'idCategorie' => $datas["categorie"]->getId(),

                'idLocalite' =>  $datas["nomLocalite"]->getId(),

                'idCommune' => $datas["nomCommune"]->getId(),

                'idCp' => $data["cp"]->getId(),

                'nomPrestataire' => $datas["nomPrestataire"] == null ? 'null' : $datas["nomPrestataire"]
            ];

            $requete = $entityManager->getRepository(Prestataire::class);

            $listePrestataire = $requete->findAllPrestataire($data,$page=$NoPage);

        }
         $tableauPrestataires = self::resultats($listePrestataire,$entityManager);//appel de la fonction resultats

//dd($tableauPrestataires[0]);
        return $this->renderForm('prestataire/index.html.twig',
            [
              'prestataireDatas' => $tableauPrestataires,

              'form' => $form,
                'donneesPrestataire' => $data
            ]
        );
    }

}
