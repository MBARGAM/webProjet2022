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

  public function is_mail($s){
        return filter_var($s, FILTER_VALIDATE_EMAIL);
    }

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
