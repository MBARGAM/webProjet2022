<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Classes\TokenCreation;
use App\Entity\Categorie;
use App\Entity\Internaute;
use App\Entity\Token;
use App\Entity\Utilisateur;
use App\Form\LoginInternauteType;
use App\Form\PreinscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class InscriptionController extends AbstractController
{
    /*
          block permettant l'envoi d'un email de confirmation
            -recuperation des données qui seront envoyées dans le mail obtenues par le formulaire de preinscription
            - mise en  place de la classe EmailSender qui est dans le dossier Classes
            -recuperation du token qui sera envoyé dans le mail
       */

    public function sendEmail($email,$nom,$prenom,$typeInscription ,$mailer, $environment,$token):void
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

            'token' => $token,

            'typeInscription' => $typeInscription,
        ];
        $newEmail = new EmailSender($mailer, $environment);

        $newEmail->sendInscriptionEmail($to, $from, $subject, $message, $template, $parametres);
    }

    /*
      block traitant la preinscription de l'internaute
         - recuperation des données du formulaire de preinscription
        - creation d'un token et insertion dans la base de données
        - envoi d'un email de confirmation
        - redirection vers la page d'accueil
        - affchahe du formulaire de preinscription si pas complété
    */

    /**
     * @Route("/internaute/{typeInscription}", name="presignupInternaute")
     */

    public function preinscription($typeInscription,Request $request,EntityManagerInterface $entityManager,MailerInterface $mailer,Environment $environment): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

        $form = $this->createForm(PreinscriptionType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            //creation d'un  d un token et insertion dans la base de données
            $newToken = new TokenCreation();

            $token = new Token();

            $token->setNom($newToken->generateToken());

            $entityManager->persist($token);

            $entityManager->flush();

            //envoi d'un email de confirmation
            $this->sendEmail($data['email'],$data['nom'],$data['prenom'],$typeInscription,$mailer,$environment,$token->getNom());

            return $this->redirectToRoute('monAccueil',["type"=>"preinscription","prenom"=>$data['prenom']]);
        }

        return $this->renderForm('inscription/index.html.twig', [

            'form' => $form,

            'typeInscription'=>$typeInscription,

            'categorie'=> $listeCategorie,

            'infoBlock' => 'menuConnexion',
        ]);
    }


    /*
     block traitant le traitement de l'inscription de l'internaute
        - recuperation des données du formulaire d' inscription
        - insertion dans la base de données
        - redirection vers la page d'accueil
   */
    /**
     * @Route("/inscriptionInternaute/{nom}/{prenom}/{typeInscription}/{email}", name="formulaireInternaute" , methods={"GET","POST"})
     */

    public function inscriptionInternaute($nom,$prenom,$typeInscription,$email,Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

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

            //insertion dans la table internaute
            $internaute = new Internaute();

            $internaute->setNom(strtolower($data['nom']));

            $internaute->setPrenom(strtolower($data['prenom']));

            $internaute->setNewsletter($data['newsletter']);

            $internaute->setBloque(0);

            $entityManager->persist($internaute);

            $entityManager->flush();

            //insertion dans la table utilisateur
            $utilisateur = new Utilisateur();

            $utilisateur->setPassword($data['mdp']);

            $password = $passwordHasher->hashPassword($utilisateur, $data['mdp']);

            $utilisateur->setPassword($password);

            $utilisateur->setEmail(strtolower($data['email']));

            $utilisateur->setInternaute($internaute);

            $utilisateur->setPassword($password);

            $utilisateur->setRoles(['INTERNAUTE']);

            $utilisateur->setAdresseRue(strtolower($adresse));

            $utilisateur->setAdresseNo(strtolower($numero));

            $utilisateur->setCommune($ville);

            $utilisateur->setLocalite($province);

            $utilisateur->setCp($cp);

            $utilisateur ->setVisible(1);

            $utilisateur ->setInscriptConf(1);

            $utilisateur ->setDateInscription(new \DateTime());

            $entityManager->persist($utilisateur);

            $entityManager->flush();

            return $this->redirectToRoute('monAccueil',["type"=>"inscription","prenom"=>$data['prenom']]);
        }
        return $this->renderForm('inscription/inscriptionInternaute.html.twig', [

            'form' => $form,

            'infoBlock' => 'menuConnexion',

            'categorie'=> $listeCategorie,

            'nom'=>$nom,

            'email'=>$email,

            'prenom'=>$prenom,

        ]);
    }

}
