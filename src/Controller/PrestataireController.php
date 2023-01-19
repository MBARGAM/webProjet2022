<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Entity\Internaute;
use App\Entity\Utilisateur;
use App\Form\LoginInternauteType;
use App\Form\PrestatairePreinnscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PrestataireController extends AbstractController
{

    public function sendEmail($email,$nom,$typeInscription ,$mailer, $environment):void
    {
        $from = 'justyn7891@yahoo.fr';
        $to = $email;
        $subject = 'Confirmation de votre inscription';
        $message = 'Bonjour '. $nom . ' vous vous êtes pre-inscrit sur notre site';
        $template = 'envoi_email/prestataire.html.twig';

        $parametres = [
            'nom' => $nom,
            'email' => $email,
            'typeInscription' => $typeInscription,
        ];
        $newEmail = new EmailSender($mailer, $environment);
        $newEmail->sendInscriptionEmail($to, $from, $subject, $message, $template, $parametres);
    }

    /**
     * @Route("/prestataire/{typeInscription}", name="presignupPrestataire")
     */
    public function preinscriptionPrestataire($typeInscription,Request $request,EntityManagerInterface $entityManager,MailerInterface $mailer,Environment $environment): Response
    {
        $form = $this->createForm(PrestatairePreinnscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            //envoi d'un email de confirmation
            $this->sendEmail($data['email'],$data['nom'],$typeInscription,$mailer,$environment);
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
     * @Route("/inscriptionPrestataire", name="formulaireInternaute" , methods={"GET","POST"})
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
            'blockdisabled' => 'oui',
        ]);
    }

}
