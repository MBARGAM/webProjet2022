<?php

namespace App\Controller;

use App\Entity\Token;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TokenController extends AbstractController
{
/* fonction statique qui recoit une date en entré , calcul la difference par rapport a la date actuelle */
    static function diffenceDate($datecreation){

        $dateActuelle = new \DateTime('now');

        $dateCreation = $datecreation;

        $interval = $dateCreation->diff($dateActuelle);

        $seconds = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->days * 86400);

        return $seconds;
    }
    /* verification du token du prestataire provenant du lien d inscription si il est toujours utilisable ou pas
     - si le lien expire : retour vers la page d accueil
     - si lien ok alors affichage du formulaire d inscription
    */
    /**
     * @Route("/token/{nom}/{typeInscription}/{email}/{token}/", name="checkTokenPrestataire")
     */

    public function prestataireToken($nom,$token,$typeInscription,$email,EntityManagerInterface $entityManager): Response
    {
        //verification du token
       $tokenVerification = $entityManager->getRepository(Token::class);

         $tokenVerification = $tokenVerification->findOneBy(['nom'=>$token]);

         $temps =  self::diffenceDate($tokenVerification->getDateCreation());//verifier la duree de validite du token

        //verification de l'existence du token et de sa validite
         if ($temps > 86400){

             //suppression du token
                $entityManager->remove($tokenVerification);

            return  $this->redirectToRoute( 'pageAccueilInformative', [

                 'msg' => 'Votre lien a expiré' ]);
         }else{

             return $this->redirectToRoute('formulairePrestataire', [

                 'typeInscription' => $typeInscription,

                 'email' => $email,

                 'nom' => $nom,

             ]);
         }

    }

    /* verification du token de l internaute provenant du lien d inscription si il est toujours utilisable ou pas
     - si le lien expire : retour vers la page d accueil
     - si lien ok alors affichage du formulaire d inscription
    */
    /**
     * @Route("/token/{nom}/{prenom}/{typeInscription}/{email}/{token}/", name="checkTokenInternaute")
     */

    public function internauteToken($nom,$prenom,$token,$typeInscription,$email,EntityManagerInterface $entityManager): Response
    {
        //verification du token
        $tokenVerification = $entityManager->getRepository(Token::class);

        $tokenVerification = $tokenVerification->findOneBy(['nom'=>$token]);

        $temps =  self::diffenceDate($tokenVerification->getDateCreation());//verifier la duree de validite du token

        //verification de l'existence du token et de sa validite
        if ($temps > 86400){

            //suppression du token
            $entityManager->remove($tokenVerification);

            return  $this->redirectToRoute( 'pageAccueilInformative', [

                'msg' => 'Votre lien a expiré' ]);
        }else{

            return $this->redirectToRoute('formulaireInternaute', [

                'typeInscription' => $typeInscription,

                'email' => $email,

                'nom' => $nom,

                'prenom' => $prenom,
            ]);
        }

    }
}
