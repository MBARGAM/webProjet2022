<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Entity\Internaute;
use App\Entity\Utilisateur;
use App\Form\InternauteType;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class EnvoiEmailController extends AbstractController
{
    /**
     * @Route("/emailinternaute/{nom}/{prenom}/{email}/{typeInscription}", name="envoiEmailInternaute")
     */

    public function sendEmailPrestataire($email,$nom,$prenom,$typeInscription ,MailerInterface $mailer, Environment $environment,Request $request,EntityManagerInterface $entityManager):Response{

            // recuperation des donnees de l internaute afin de faire une mail de confirmation
            $data = [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'typeInscription' => $typeInscription
            ];

            $from = 'justyn7891@yahoo.fr';
            $to = $data['email'];
            $subject = 'Confirmation de votre inscription';
            $message = 'Bonjour '.$data['prenom'].' '.$data['nom'].' vous vous êtes pre-inscrit sur notre site';
            $template = 'envoi_email/index.html.twig';

            $parametres = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'typeInscription' => $data['typeInscription']
            ];
            $newEmail = new EmailSender($mailer,$environment);
            $newEmail->sendInscriptionEmail($to,$from,$subject,$message,$template,$parametres);


           return $this->redirectToRoute('pageAccueil');

    }

    /**
     * @Route("/emailprestataire/{nom}/{prenom}/{email}", name="envoiMailPrestataire")
     */

    public function sendEmailInternaute(): void
    {
        $newEmail = new EmailSender();
        $newEmail->sendInscriptionEmail();
        $this->addFlash('success', 'Veuillez consulter votre boite mail pour activer votre compte');
    }

}
?>
