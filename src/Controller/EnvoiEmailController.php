<?php

namespace App\Controller;

use App\Entity\Utilisateur;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class EnvoiEmailController extends AbstractController
{

     /*  fonction permettant de verifier si un email est valide ou non */
      public function is_mail($s){
            return filter_var($s, FILTER_VALIDATE_EMAIL);
      }

    /*
      block permettant de verifier l existence ou non de l email de l internaute dans la base de donnees
        - le code ajax envoie l email a verifier
        - le code php verifie si l email existe ou non dans la base de donnees
        - le code php renvoie une reponse au code ajax
    */
    /**
     * @Route("/internaute/email/{email}", name="internaiteCheckEmail" )
     */

    public function internauteCheckEmail($email,EntityManagerInterface $entityManager): Response
    {
        if($this->is_mail($email)){

            $searchEmail = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

            if(!empty($searchEmail)){

               return new Response('false');

            }else{
               return new Response('true');
            }

        }else{

           return new Response('false');
        }
    }


    /*
     block permettant de verifier l existence ou non de l email du prestataire dans la base de donnees
       - le code ajax envoie l email a verifier
       - le code php verifie si l email existe ou non dans la base de donnees
       - le code php renvoie une reponse au code ajax
   */
    /**
     * @Route("/prestataire/email/{email}", name="prestataireCheckEmail" )
     */

    public function prestataireCheckEmail($email,EntityManagerInterface $entityManager): Response
    {
        if($this->is_mail($email)){

            $searchEmail = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

            if(!empty($searchEmail)){

                return new Response('false');

            }else{

                return new Response('true');
            }

        }else{

            return new Response('false');
        }
    }

}
?>
