<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Entity\CodePostal;
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

            //recuperation des données du formulaire sur la localisation de l internaute
            $numero= $data['numero'];
            $adresse= $data['adresse'];
            $cp= $data['codepostal'];
            $ville= $data['commune'];
            $province= $data['province'];

            //mise en des differentes  des donnees pour differentes insertions
            //insertion dans la table internaute
            $internaute = new Internaute();
            $internaute->setNom($data['nom']);
            $internaute->setPrenom($data['prenom']);
            $internaute->setNewsletter($data['newsletter']);
            $internaute->setBloque(0);
            $entityManager->persist($internaute);
            $entityManager->flush();

            //recuperation de l id de l internaute
          //  $repository = $entityManager->getRepository(Internaute::class);
          //  $lastInternauteId = $repository->findLastId();
            //dd($lastInternauteId);
          //  $lastInternauteInsert = $lastInternauteId[0]['id'];

            //insertion dans la table utilisateur
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($data['email']);
            $utilisateur->setInternaute($internaute);
            $utilisateur->setPassword($data['mdp']);
            $utilisateur->setRoles(['INTERNAUTE']);
            $utilisateur->setAdresseRue($adresse);
            $utilisateur->setAdresseNo($numero);
            $utilisateur->setCommune($ville);
            $utilisateur->setLocalite($province);
            $utilisateur->setCp($cp);
            $utilisateur ->setVisible(0);
            $utilisateur ->setInscriptConf(0);
            $utilisateur ->setDateInscription(new \DateTime());

            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('pageAccueil');
        }
        return $this->renderForm('inscription/inscriptionInternaute.html.twig', [
            'form' => $form,

        ]);
    }

}

/*
 SELECT CONCAT(nom," ",prenom) AS Nom ,email,concat(utilisateur.adresse_no,",",utilisateur.adresse_rue) AS Adresse ,code_postal.cp ,commune.commune, localite.localite FROM `internaute`
INNER JOIN utilisateur ON utilisateur.internaute_id = internaute.id
INNER JOIN code_postal ON utilisateur.cp_id = code_postal.id
INNER JOIN commune on commune.id = code_postal.id
INNER JOIN localite on localite.id = code_postal.localite_id
ORDER BY nom , prenom ASC
*/