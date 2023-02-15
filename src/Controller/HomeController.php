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
       // dd($categorieChoisie);

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
            'infoBlock' => 'menuConnexion',


        ]);
    }

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

    /**
     * @Route("/accueil/{msg}", name="pageAccueilInformative")
     */
    public function lapage ($msg,Request $request,EntityManagerInterface $entityManager): Response
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
        // dd($categorieChoisie);

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
            'infoBlock' => 'menuConnexion',
            'msg' => $msg

        ]);
    }

}
