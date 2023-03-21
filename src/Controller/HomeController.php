<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Image;
use App\Entity\Localite;
use App\Entity\Prestataire;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function home(): response
    {
      return  $this->redirectToRoute("pageAccueil");
    }


    /*
      page d'accueil
       - recupere les donnees de la base de donnees pour les afficher sur la page d'accueil
   */
    /**
     * @Route("/accueil", name="pageAccueil")
     */
    public function search(Request $request,EntityManagerInterface $entityManager): Response
    {
        $commune = $entityManager->getRepository(Commune::class);

        $listeCommune = $commune-> findAllCommune();

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findAllLocalite();

        $cp = $entityManager->getRepository(CodePostal::class);

        $listeCp= $cp->findAllCp();

        // Obtention des 4 prestataires les plus récents
        $prestataire = $entityManager->getRepository(Prestataire::class);

        $listePrestataire = $prestataire->lastPrestataireInsert();

        if ($listePrestataire != null){

            $prestataireDatas = [];

            foreach ($listePrestataire as $data){

                $userImgData = [];

                $req = $entityManager->getRepository(Image::class);

                $listeImage = $req->findPicName($data->getId());

                if($listeImage != null){

                    $userImgData[] = $data;

                    $userImgData[] = $listeImage[0]['nom'];

                    $prestataireDatas[] = $userImgData;

                }else{

                    $prestataireDatas[] = $userImgData;

                }
            }
        }else{

            $prestataireDatas = null;
        }

      // recuperation de la categorie choisie par la prestataire

        $req = $entityManager->getRepository(Categorie::class);

        $categorieChoisie= $req->findCategorieChoisie();
        if($categorieChoisie == null){

            $monImage =  'categorie.jpg';

            $categorieChoisie  = ["null",$monImage];
        }
        else
        {

            $categorieChoisie = $categorieChoisie[0];

            $img =$categorieChoisie->getImage() == null  ? null : $categorieChoisie->getImage()->getNom();

            $monImage = $img == null ? 'categorie.jpg' : $img;

            $categorieChoisie  = [$categorieChoisie,$monImage];
        }


        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        $data = $form->getData();

        $idCategorie = $data["categorie"]->getId();

        $idLocalite = $data["nomLocalite"]->getId();

        $idCommune = $data["nomCommune"]->getId();

        $idCp = $data["cp"]->getId();

        $nomPrestataire  =  $data["nomPrestataire"] == null ? 'null' : $data["nomPrestataire"];

       return $this->redirectToRoute('search', [

        'idCategorie' => $idCategorie,

        'idLocalite' => $idLocalite,

        'idCommune' => $idCommune,

        'idCp' => $idCp,

        'NoPage'=> 1,

        'nomPrestataire' => $nomPrestataire

            ]);
        }

        return $this->renderForm('home/index.html.twig', [

            'form' => $form,

            'commune'=>$listeCommune,

            'localite'=>$listeLocalite,

            'cp'=>$listeCp,

            'categorie'=> $listeCategorie,

            'categorieChoisie'=>$categorieChoisie,

            'prestataires'=>$prestataireDatas,

        ]);
    }

    /*
         page d'accueil apres la presinscription
        - recuperer les donnees de la base de donnees pour les afficher sur la page d'accueil
        - affiche le prenom de l'utilisateur qui vient de se presinscrire avec un message de bienvenue
   */

    /**
     * @Route("/accueil/preinscription/{prenom}", name="monAccueil")
     */
    public function pageAcceilAprèspresinscription($prenom,Request $request,EntityManagerInterface $entityManager): Response
    {
        $commune = $entityManager->getRepository(Commune::class);

        $listeCommune = $commune-> findAllCommune();

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findAllLocalite();

        $cp = $entityManager->getRepository(CodePostal::class);

        $listeCp= $cp->findAllCp();

        // Obtention des 4 prestataires les plus récents
        $prestataire = $entityManager->getRepository(Prestataire::class);

        $listePrestataire = $prestataire->lastPrestataireInsert();

        if ($listePrestataire != null){

            $prestataireDatas = [];

            foreach ($listePrestataire as $data){

                $userImgData = [];

                $req = $entityManager->getRepository(Image::class);

                $listeImage = $req->findPicName($data->getId());

                if($listeImage != null){

                    $userImgData[] = $data;

                    $userImgData[] = $listeImage[0]['nom'];

                    $prestataireDatas[] = $userImgData;

                }else{

                    $prestataireDatas[] = $userImgData;

                }

            }
        }

        //choix  d'une categorie aleatoire a afficher sur la page d'accueil

        $tailleCatehgories = count($listeCategorie);

        $random = rand(0,$tailleCatehgories-1);

        $categorieAleatoire = $listeCategorie[$random];

        $img =$categorieAleatoire->getImage() == null  ? null : $categorieAleatoire->getImage()->getNom();

        $monImage = $img == null ? 'categorie.jpg' : $img;

        $categorieChoisie  = [$categorieAleatoire,$monImage];

        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        // recuperaion des données du formulaire et envoi de la data vers la controlleur de recherche pour afficher les resultats
        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $idCategorie = $data["categorie"]->getId();

            $idLocalite = $data["nomLocalite"]->getId();

            $idCommune = $data["nomCommune"]->getId();

            $idCp = $data["cp"]->getId();

            $nomPrestataire  =  $data["nomPrestataire"] == null ? 'null' : $data["nomPrestataire"];

            return $this->redirectToRoute('search', [

                'idCategorie' => $idCategorie,

                'idLocalite' => $idLocalite,

                'idCommune' => $idCommune,

                'idCp' => $idCp,

                'NoPage'=> 1,

                'nomPrestataire' => $nomPrestataire
            ]);
        }

        $message =  ucfirst($prenom ).  " , Un email de confirmation vous a été envoyé, veuillez le consulter svp!!";

        return $this->renderForm('home/index.html.twig', [

            'form' => $form,

            'commune'=>$listeCommune,

            'localite'=>$listeLocalite,

            'cp'=>$listeCp,

            'categorie'=> $listeCategorie,

            'categorieChoisie'=>$categorieChoisie,

            'prestataires'=>$prestataireDatas,

            "message"=>$message

        ]);
    }

    /*
      block traitant l autocompletion des champs de recherche
         - recuperation des donnees envoyees par la requete ajax
         - envoi des donnees vers la base de donnees
         - recuperation des donnees de la base de donnees
         - envoi des donnees vers ajax
   */

     /**
      * @Route("accueil/{id}", name="autocompletion" , methods="POST")
      */

    public function autofill($id,Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $commune = $entityManager->getRepository(Commune::class);

        $listeCommune = $commune-> findCommune($id);

        $listeCommune = $serializer->serialize($listeCommune, 'json', [AbstractNormalizer::ATTRIBUTES => ['commune','id']]);

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findLocalite($id);

        $listeLocalite= $serializer->serialize($listeLocalite,'json',[AbstractNormalizer:: ATTRIBUTES =>['localite','id']]);

        $result=['commune'=>$listeCommune,'localite'=>$listeLocalite];

          return new JsonResponse($result);
    }

    /*
      block traitant l autocompletion des champs de recherche
         - recuperation des donnees envoyees par la requete ajax
         - envoi des donnees vers la base de donnees
         - recuperation des donnees de la base de donnees
         - envoi des donnees vers ajax
   */

    /**
     * @Route("/user/{id}", name="autocomplete1" , methods="POST")
     */

    public function autofillsearch($id,Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $commune = $entityManager->getRepository(Commune::class);

        $listeCommune = $commune-> findCommune($id);

        $listeCommune = $serializer->serialize($listeCommune, 'json', [AbstractNormalizer::ATTRIBUTES => ['commune','id']]);

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findLocalite($id);

        $listeLocalite= $serializer->serialize($listeLocalite,'json',[AbstractNormalizer:: ATTRIBUTES =>['localite','id']]);

        $result=['commune'=>$listeCommune,'localite'=>$listeLocalite];


        return new JsonResponse($result);
    }

    /*
      block traitant l autocompletion des champs de recherche
         - recuperation des donnees envoyees par la requete ajax
         - envoi des donnees vers la base de donnees
         - recuperation des donnees de la base de donnees
         - envoi des donnees vers ajax
   */

    /**
     * @Route("/accueil/{msg}", name="pageAccueilInformative")
     */
    public function lapPageAccueil ($msg,Request $request,EntityManagerInterface $entityManager): Response
    {
        $commune = $entityManager->getRepository(Commune::class);

        $listeCommune = $commune-> findAllCommune();

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findAllLocalite();

        $cp = $entityManager->getRepository(CodePostal::class);

        $listeCp= $cp->findAllCp();

        // Obtention des 4 prestaaires les plus récents
        $prestataire = $entityManager->getRepository(Prestataire::class);

        $listePrestataire = $prestataire->lastPrestataireInsert();

        $prestataireDatas = [];

        foreach ($listePrestataire as $data){

            $userImgData = [];

            $req = $entityManager->getRepository(Image::class);

            $listeImage = $req->findPicName($data->getId());

            $userImgData[] = $data;

            $userImgData[] = $listeImage[0]['nom'];

            $prestataireDatas[] = $userImgData;
        }

        //choix  d'un categorie aleatoire a afficher sur la page d'accueil
        //choix aléatoire d'une categorie
        $tailleCatehgories = count($listeCategorie);

        $random = rand(0,$tailleCatehgories-1);

        $categorieAleatoire = $listeCategorie[$random];

        // recuperation de l'image de la categorie
        $image = $entityManager->getRepository(Image::class);

        $categoryImage = $image->findCategoryPicName($categorieAleatoire->getId());

        // ternaire pour verifier si la categorie a une image
        $monImage = $categoryImage == null ? 'categorie.jpg' : $categoryImage[0]['nom'];

        $categorieChoisie  = [$categorieAleatoire,$monImage];

        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);


        return $this->renderForm('home/index.html.twig', [

            'form' => $form,

            'commune'=>$listeCommune,

            'localite'=>$listeLocalite,

            'cp'=>$listeCp,

            'categorie'=> $listeCategorie,

            'categorieChoisie'=>$categorieChoisie,

            'prestataires'=>$prestataireDatas,

            'msg' => $msg

        ]);
    }

}
