<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Entity\Internaute;
use App\Entity\Prestataire;
use App\Entity\Utilisateur;
use App\Form\InternauteType;
use App\Form\LoginInternauteType;
use App\Form\PreinscriptionType;
use App\Form\PrestatairePreinnscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class InscriptionController extends AbstractController
{
//fonction qui permet de D'envoyer un mail de confirmation d'inscription

    public function sendEmail($email,$nom,$prenom,$typeInscription ,$mailer, $environment):void
    {
        $from = 'justyn7891@yahoo.fr';
        $to = $email;
        $subject = 'Confirmation de votre inscription';
        $message = 'Bonjour ' . $prenom . ' ' . $nom . ' vous vous êtes pre-inscrit sur notre site';
        $template = 'envoi_email/index.html.twig';

        $parametres = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'typeInscription' => $typeInscription,
        ];
        $newEmail = new EmailSender($mailer, $environment);
        $newEmail->sendInscriptionEmail($to, $from, $subject, $message, $template, $parametres);
    }

    //validation de la pre inscription et envoi d'un email de confirmation
    /**
     * @Route("/internaute/{typeInscription}", name="presignupInternaute")
     */

    public function preinscription($typeInscription,Request $request,EntityManagerInterface $entityManager,MailerInterface $mailer,Environment $environment): Response
    {
        $form = $this->createForm(PreinscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            //envoi d'un email de confirmation
            $this->sendEmail($data['email'],$data['nom'],$data['prenom'],$typeInscription,$mailer,$environment);

            return $this->redirectToRoute('pageAccueil');
        }
        return $this->renderForm('inscription/index.html.twig', [
            'form' => $form,
            'typeInscription'=>$typeInscription,
            'blockdisabled' => 'oui',
        ]);
    }


    // confirmation de l'inscription et insertion dans la base de données internaute et utilisateur

    /**
     * @Route("/inscriptionInternaute", name="formulaireInternaute" , methods={"GET","POST"})
     */


    public function inscriptionInternaute(Request $request,EntityManagerInterface $entityManager): Response
    {

        $form=$this->createForm(LoginInternauteType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            dd($data);
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('pageAccueil');
        }
        return $this->renderForm('inscription/inscriptionInternaute.html.twig', [
            'form' => $form,
            'blockdisabled' => 'oui',
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