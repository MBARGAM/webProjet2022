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
