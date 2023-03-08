<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Localite;
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

    // route de redirection de la composante rechercher
    /**
     * @Route("/rechercher/{idCategorie}/{idLocalite}/{idCommune}/{idCp}/{nomPrestataire}/{NoPage}", name="search")
     */

    public function index($idCategorie,$idLocalite,$idCommune,$idCp,$nomPrestataire,$NoPage,Request $request,EntityManagerInterface $entityManager): Response
    {

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

                'nomPrestataire' => $data["nomPrestataire"]== null ? 'null' : $data["nomPrestataire"],

                'NoPage'=>1
            ];

            return $this->redirectToRoute('search', [

                'idCategorie' => $data["idCategorie"],

                'idLocalite' => $data["idLocalite"],

                'idCommune' => $data["idCommune"],

                'idCp' => $data["idCp"],

                'NoPage'=> 1,

                'nomPrestataire' => $data["nomPrestataire"]
            ]);

        }

        //donnees recues du formulaire de recherche soumis en dehors de la page de recherche
        $data = [
            'idCategorie' => $idCategorie,

            'idLocalite' => $idLocalite,

            'idCommune' => $idCommune,

            'idCp' => $idCp,

            'nomPrestataire' => $nomPrestataire,

            'NoPage'=>$NoPage
        ];


       // premier appel de la fonction resultats pour recuperer le tableau des prestataires recherchés
        // afin de verifier si le tableau est vide ou non et de definir une limite sur la page a
        $requete = $entityManager->getRepository(Prestataire::class);

        $listePrestataire = $requete->findAllPrestataire($data,$laPage=$NoPage);

        $tabPrestataire = self::resultats($listePrestataire,$entityManager);


       /* cette operation permet de gerer la pagination du resultat de la recherche et de la page de recherche
         ici l affichage est fait avec 12 prestataires par page et ensuite on calcule le nbre de page que le resultat et on affiche
       les 2 nbres multiple de 5 les plus proche*/

        if(  intdiv(count($tabPrestataire),12) < $data["NoPage"] ){

            if( intdiv(count($tabPrestataire),12) == 0){

                    $debutIteration = 1;

                    $finIteration = 5;

                    $page = 1;
            }else{

                $debutIteration = ((count($tabPrestataire)/12 / 5) * 5 )  + 1 ; // debut de l iteration de la pagination

                $finIteration =  ((count($tabPrestataire)/12 + 4) / 5) * 5; // fin de l iteration de la pagination

                $page = $debutIteration;
            }

        }else{


            $debutIteration = (intdiv($data["NoPage"],5)) * 5  + 1; // debut de l iteration de la pagination

            $finIteration = (($data["NoPage"]  + 4) / 5) * 5;  // fin de l iteration de la pagination

            $page = $data["NoPage"];
        }

        /* 2eme appel de la fonction resultats : elle est appelee pour recuperer le tableau des prestataires recherchés reelement et a afficher
        selon les conditions de pagination
        LE RESULTAT DE LA RECHERCHE - DEPEND DU NOMBRE DE PRESTATAIRES TROUVES SI MOIN DE 12 PRESTATAIRES
        ALORS ON AURA UNE MEME PAGE QUELQUE SOIT LE PAGE CLIQUé
        */
        $listePrestataire = $requete->findAllPrestataire($data,$laPage=$page);

        $tabPrestataire = self::resultats($listePrestataire,$entityManager);


        $data["debutIteration"] = $debutIteration;

        $data["finIteration"] = $finIteration;


        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findAllLocalite();



        return $this->render('prestataire/index.html.twig', [

            'form' => $form->createView(),

            'prestataireDatas' => $tabPrestataire,

            'donneesPrestataire' => $data,

            'categorie' => $listeCategorie,

            'localite' => $listeLocalite

        ]);
    }

    /**
     * @Route("/recherche/rapide", name="fastSearch")
     */

    public function rechercheRapide(EntityManagerInterface $entityManager,Request $request): Response
    {
        $action = $request->request->all();

        $data = [
            'idCategorie' => $action["categorie"]== null ? 'null' : $action["categorie"],

            'idLocalite' => $action["localite"]== null ? 'null' : $action["localite"],

            'idCommune' => 'null',

            'idCp' => 'null',

            'nomPrestataire' => $action["prestataire"]== null ? 'null' : $action["nomPrestataire"],

            'NoPage'=>1
        ];


           return $this->redirectToRoute('search', [

            'idCategorie' => $data["idCategorie"],

            'idLocalite' => $data["idLocalite"],

            'idCommune' => $data["idCommune"],

            'idCp' => $data["idCp"],

            'nomPrestataire' => $data["nomPrestataire"],

            'NoPage'=> $data["NoPage"],

      ]);
    }


}
