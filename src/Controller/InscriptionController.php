<?php

namespace App\Controller;

use App\Entity\Internaute;
use App\Entity\Prestataire;
use App\Entity\Utilisateur;
use App\Form\InternauteType;
use App\Form\PreinscriptionType;
use App\Form\PrestatairePreinnscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /*route de preinscription d un utilisateur (internaute ou prestataire)
    - de traitement de la preinscription
    - si formulaire ok
      *  insertion dans la bd table internaute ou prestataire
      *  redirection vers la creation du formulaire compte d inscription
      *  creation et envoi d un email pour completer l inscription */

    /**
     * @Route("/internaute/{typeInscription}", name="presignupInternaute")
     */

    public function preinscription($typeInscription,Request $request,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PreinscriptionType::class);
        $form->handleRequest($request);

        // recuperation des donnees du formulaire de preinscription et ajout dans la bd
        // 2 tables sont concernées : la table utilisateur et la table internaute ou prestataire
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            // redirection vers la creation de l'email
            return $this->redirectToRoute('envoiEmailInternaute',[
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' =>$data['email'],
                'typeInscription'=>$typeInscription
            ]);
        }

        return $this->renderForm('inscription/index.html.twig', [
            'form' => $form,
            'typeInscription'=>$typeInscription,
            'blockdisabled' => 'oui',
        ]);
    }


    /**
     * @Route("/prestataire/{typeInscription}", name="presignupPrestataire")
     */

    public function preinscriptionPrestataire($typeInscription,Request $request,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrestatairePreinnscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            return $this->redirectToRoute('envoiMailInternaute',[
                'nom' => $data['nom'],
                'email' =>$data['email'],
                'typeInscription'=>$typeInscription
            ]);
        }

        return $this->renderForm('inscription/index.html.twig', [
            'form' => $form,
            'typeInscription'=>$typeInscription,
            'blockdisabled' => 'oui',
        ]);
    }

    /**
     * @Route("/inscriptionInternaute/{nom}/{prenom}/{email}/{typeInscription}", name="formulaireInternaute",methods={"GET"})
     */

    public function inscriptionInternaute($nom,$prenom,$email,$typeInscription,Request $request,EntityManagerInterface $entityManager): Response
    {
        $internaute = new Internaute();
        $internaute->setNom($nom);
        $internaute->setPrenom($prenom);
        $form=$this->createForm(InternauteType::class,$internaute);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('pageAccueil');
        }
        return $this->renderForm('inscription/inscriptionInternaute.html.twig', [
            'form' => $form,
            'typeInscription'=>$typeInscription,
            'blockdisabled' => 'non',
        ]);
    }



}

/*
                               // insertion du nom et prenom de l internaute et recuperation de l id pour insertion dans la table utilisateur
                                  $internaute = new Internaute();
                                  $internaute->setNom($data['nom']);
                                    $internaute->setPrenom($data['prenom']);
                                    $entityManager->persist($internaute);
                                    $entityManager->flush();

                                 //recuperation de l id de l internaute
                                 $repository = $entityManager->getRepository(Internaute::class);
                                 $lastPrestataireId = $repository->findLastId();
                                 $lastPrestataireId = $lastPrestataireId[0]['id'];

                               insertion de l email de l internaute et de l id de l internaute dans la table utilisateur
                                 $utilisateur = new Utilisateur();
                                 $utilisateur->setEmail($data['email']);
                                 $utilisateur->setInternaute($lastPrestataireId);
                                 $entityManager->persist($utilisateur);
                                 $entityManager->flush();
*/

/*

                              $prestataire = new Prestataire();
                            $prestataire->setNom($data['nom']);
                            $entityManager->persist($prestataire);
                            $entityManager->flush();//recuperation de l id du prestataire
                            $repository = $entityManager->getRepository(Prestataire::class);
                            $lastPrestataireId = $repository->findLastId();
                            $lastPrestataireId = $lastPrestataireId[0]['id'];

                            insertion de l email du prestataire et de l id de l internaute dans la table utilisateur
                            $utilisateur = new Utilisateur();
                            $utilisateur->setEmail($data['email']);
                            $utilisateur->setPrestataire($lastPrestataireId);
                            $entityManager->persist($utilisateur);
*/
/*
            $newInternaute = new Internaute();
            $newInternaute ->setNom($data['nom']);
            $newInternaute ->setPrenom($data['prenom']);
            $newInternaute ->setNewsletter('false');
            $newInternaute ->setBloque('false');
            $entityManager->persist($newInternaute );
            $entityManager->flush();

            // insertion dans la table utilisateur
            $newUtilisateur = new Utilisateur();
            $newUtilisateur ->setEmail($data['email']);
            $newUtilisateur ->setInternaute($newInternaute);
            $newUtilisateur ->setRoles(['INTERNAUTE']);
            $newUtilisateur ->setVisible('false');
            $newUtilisateur ->setInscriptConf('false');
            $newUtilisateur ->setDateInscription(new \DateTime());
            $entityManager->persist($newUtilisateur);
            $entityManager->flush();*/