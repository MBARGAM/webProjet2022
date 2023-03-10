<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,EntityManagerInterface $entityManager): Response
    {

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();//liste des categories

         if ($this->getUser()) {

            return $this->redirectToRoute('dispatcher');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',

            ['last_username' => $lastUsername,

                'error' => $error,

                'categorie' => $listeCategorie,
            ]);
    }

    /**
     * @Route("/deconnexion", name="app_logout" , methods={"GET"})
     */
    public function logout(): Response
    {
      //  throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

     return $this->redirectToRoute('pageAccueil');
    }

    /**
     * @Route("/userType", name="dispatcher" )
     */
    public function dispatcher(): Response
    {
        $user = $this->getUser();// recupere l'utilisateur connecté envoye par le security.yaml

        $roles = $user->getRoles();// recupere le tableau role de l'utilisateur

        $role = $roles[0]; // recupere le role de l'utilisateur

         $id = $user->getId();

        if($role == "ADMIN"){

            return $this->redirectToRoute('administrateurPage', ['id' => $id]);

        }elseif($role == "PRESTATAIRE"){

            return $this->redirectToRoute('profilPrestataire', ['id' => $id, 'role' => $user->getRoles()[0]]);

        }elseif($role == "INTERNAUTE"){

            return $this->redirectToRoute('profilInternaute', ['id' => $id]);

        }else{

            return $this->redirectToRoute('pageAccueil');

        }
    }
}
