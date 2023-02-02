<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
            return $this->redirectToRoute('dispatcher');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="app_logout" , methods={"GET"})
     */
    public function logout(): Response
    {
        //dd(["oui"]);
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

        if($role == "ADMIN"){
            return $this->redirectToRoute('profilAdmin', ['id' => $user->getId()]);
        }elseif($role == "PRESTATAIRE"){
            return $this->redirectToRoute('profilPrestataire', ['id' => $user->getId()]);
        }elseif($role == "INTERNAUTE"){
            return $this->redirectToRoute('profilInternaute', ['id' => $user->getId()]);
        }else{
            return $this->redirectToRoute('pageAccueil');
        }
    }
}
