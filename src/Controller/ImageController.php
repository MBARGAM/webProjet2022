<?php

namespace App\Controller;


use App\Classes\FileLoader;
use App\Entity\Image;
use App\Entity\Prestataire;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageController extends AbstractController
{
    /*
      block traitant l'upload des images
     -recuperation des images
        -traitement des images par la classe FileLoader qui est dans le dossier Classes
        -enregistrement des images dans la base de données

   */
    /**
     * @Route("/image/{id}", name="lesImages")
     */
    public function index($id,EntityManagerInterface $entityManager,Request $request,SluggerInterface $slugger): Response
    {

        $form = $this->createForm(ImageType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //recuperation de l'objet Prestataire ayant rempli le formulaire
            $prestataire = $entityManager->getRepository(Prestataire::class);

            $prestataire = $prestataire->find($id);

            $logoFile = $form->get('logo')->getData();

            $photoFile = $form->get('photo')->getData();

            //traitement du logo recupéré du formulaire
            if($logoFile){

               $fileLoader = new FileLoader($slugger);

                $logo = $fileLoader->uploadLogo($logoFile);

                $image = new Image();

                $image->setNom($logo);

                $image->setPrestataire($prestataire);

                $entityManager->persist($image);

                $entityManager->flush();
            }
             //traitement de la photo recupéré du formulaire
            if($photoFile) {

                $fileLoader = new FileLoader($slugger);

                $photo = $fileLoader->upload($photoFile);

                $image = new Image();

                $image->setNom($photo);

                $image->setPrestataire($prestataire);

                $entityManager->persist($image);

                $entityManager->flush();
            }
            return $this->redirectToRoute('lesPromotions', ['id' => $id]);
        }
        return $this->renderForm('image/index.html.twig', [

            'form' => $form,

            'infoBlock' => 'menuConnexion'
        ]);
    }
}
