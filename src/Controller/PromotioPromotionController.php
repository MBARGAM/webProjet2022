<?php

namespace App\Controller;

use App\Classes\FileLoader;
use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Prestataire;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use App\Form\PromotionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PromotioPromotionController extends AbstractController
{
    /*
         block traitant l affichage du formulaire pour l enregistrement d une promotion
        - récuperation des données du formulaire de promotion
        - envoi des donnees dans la bd si le formulaire est valide
        - envoi des parametres du formulaire vers
   */

    /**
     * @Route("/promotion/{id}", name="lesPromotions")
     */
    public function index($id,EntityManagerInterface $entityManager,Request $request,SluggerInterface $slugger): Response
    {
        $categories = $entityManager->getRepository(Categorie::class);

        $categories = $categories->findAllCategorie();

        $promotion = new Promotion();

        $form = $this->createForm(PromotionType::class,$promotion);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //recuperation de l'objet Prestataire ayant rempli le formulaire
             $prestataire = $entityManager->getRepository(Prestataire::class);

             $prestataire = $prestataire->find($id);

             $data = $form->getData();

             $pdfFile = $form->get('document')->getData();

            //verification des champs
            if($data->getNom() != null && $data->getDescription() != null  ){

                $promotion->setPrestataire($prestataire);

                $promotion->setNom($data->getNom());

                $promotion->setDescription($data->getDescription());

                $promotion->setDebutAffichage($data->getDebutAffichage());

                $promotion->setFinAffichage($data->getFinAffichage());

                $entityManager->persist($promotion);

                $entityManager->flush();

                //traitement du fichier pdf
                // if $pdf is not null, it means that the file was uploaded
                if($pdfFile != null){

                    $fileLoader = new FileLoader($slugger);

                    $pdf = $fileLoader->uploadPdf($pdfFile);

                    $image = new Image();

                    $image->setNom($pdf);

                    $image->setPrestataire($prestataire);

                    $entityManager->persist($image);

                    $entityManager->flush();
                }
            }
            return $this->redirectToRoute('lesStages', ['id' => $id]);

        }

        return $this->renderForm('promotio_promotion/index.html.twig', [

            'form' => $form,

            'categories' => $categories
        ]);
    }

    /*
         block traitant l ajout d une promotion
        - récuperation des données du formulaire de promotion ajouté par un prestataire
        - envoi des donnees dans la bd si le formulaire est valide
   */

    /**
     * @Route("/user/ajout/promotion/{id}", name="ajoutPromotion")
     */
    public function ajoutPromotion($id,EntityManagerInterface $entityManager,Request $request,SluggerInterface $slugger): Response
    {
        $categories = $entityManager->getRepository(Categorie::class);

        $categories = $categories->findAllCategorie();

        $promotion = new Promotion();

        $form = $this->createForm(PromotionType::class,$promotion);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //recuperation des donnees du prestataire connecte
            // recuperation de l'id du prestataire dans la table user

            $req = $entityManager->getRepository(Utilisateur::class);

            $prestataireId = $req->findPrestataireUser($id);

            $idPrestatataire = $prestataireId[0]->getPrestataire()->getId();

            //recuperation de l'objet Prestataire ayant rempli le formulaire
            $prestataire = $entityManager->getRepository(Prestataire::class);

            $prestataire = $prestataire->find( $idPrestatataire);

            $data = $form->getData();

            $pdfFile = $form->get('document')->getData();

            //verification des champs
            if($data->getNom() != null && $data->getDescription() != null  ){

                $promotion->setPrestataire($prestataire);

                $promotion->setNom($data->getNom());

                $promotion->setDescription($data->getDescription());

                $promotion->setDebutAffichage($data->getDebutAffichage());

                $promotion->setFinAffichage($data->getFinAffichage());

                $entityManager->persist($promotion);

                $entityManager->flush();

                if($pdfFile != null){

                    //traitement du fichier pdf
                    $fileLoader = new FileLoader($slugger);

                    $pdf = $fileLoader->uploadPdf($pdfFile);

                    $image = new Image();

                    $image->setNom($pdf);

                    $image->setPrestataire($prestataire);

                    $entityManager->persist($image);

                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('profilPrestataire', ['id' => $id, 'role' => 'PRESTATAIRE' ]);
        }
        return $this->renderForm('promotio_promotion/ajoutPromotion.html.twig', [

            'form' => $form,

            'typeUser' => 'PRESTATAIRE',

            'categories' => $categories

        ]);
    }

    // block traitant l affichage de la promotion courante

    /**
     * @Route("user/promotion/{id}", name="promotionCourante")
     */
    public function stage($id,EntityManagerInterface $entityManager,Request $request): Response
    {

        return $this->renderForm('stage/index.html.twig', [

            'infoBlock' => 'menuConnexion',
        ]);
    }
}
