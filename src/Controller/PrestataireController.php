<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Entity\Categorie;
use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Image;
use App\Entity\Localite;
use App\Entity\Prestataire;
use App\Entity\Promotion;
use App\Entity\Stage;
use App\Entity\Utilisateur;
use App\Form\LoginPrestatataireType;
use App\Form\PrestatairePreinnscriptionType;
use App\Form\PrestataireSearchType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        $categorie = $entityManager->getRepository(Categorie::class);
        $listeCategorie = $categorie-> findAllCategorie();
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
            'infoBlock' => 'menuConnexion',
            'categorie'=> $listeCategorie,

        ]);
    }

    // confirmation de l'inscription et insertion dans la base de données internaute et utilisateur
    /**
     * @Route("/inscriptionPrestataire", name="formulairePrestataire" , methods={"GET","POST"})
     */

    public function inscriptionPrestataire(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class);
        $listeCategorie = $categorie-> findAllCategorie();
        $form=$this->createForm(LoginPrestatataireType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

         // dd($form->get('photo')->getData());
            //recuperation des données du formulaire sur la localisation de l internaute
            $numero= $data['numero'];
            $adresse= $data['adresse'];
            $cp= $data['codepostal'];
            $ville= $data['commune'];
            $province= $data['province'];


            //mise en des differentes  des donnees pour differentes insertions
            //insertion dans la table prestataire
            $prestataire = new Prestataire();
            $prestataire->setNom(strtolower($data['nom']));
            $prestataire->setDescription(strtolower($data['description']));
            $prestataire->setSiteweb(strtolower($data['siteweb']));
            $prestataire->setNumeroTva(strtolower($data['tva']));
            $prestataire->setTel(strtolower($data['tel']));
            $prestataire->setBloque(0);
            $entityManager->persist($prestataire);
            $entityManager->flush();
            //recuperation de l'id du prestataire pour les images les stages et les promotions
            $lastId = $prestataire->getId();
            //dd($data);
            //mise a jour de la  table utilisateur
            $utilisateur = new Utilisateur();

            //hashage du mot de passe
            $utilisateur->setPassword($data['mdp']);
            $password = $passwordHasher->hashPassword($utilisateur,$data['mdp']);
            $utilisateur->setPassword($password);
            $utilisateur->setEmail(strtolower($data['email']));
            $utilisateur->setPrestataire($prestataire);
            $utilisateur->setRoles(['PRESTATAIRE']);
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
            return $this->redirectToRoute('lesImages', ['id' => $lastId]);
        }
        return $this->renderForm('inscription/inscriptionPrestataire.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
            'categorie'=> $listeCategorie,
        ]);
    }

    // profil du prestataire
    /**
     * @Route("/profilPrestataire/{id}/{role}", name="profilPrestataire")
     */
    public function profilPrestataire($id,$role,Request $request,EntityManagerInterface $entityManager): Response
    {
       // donnees pour le formulaire de recherche
        $commune = $entityManager->getRepository(Commune::class);
        $listeCommune = $commune-> findAllCommune();
        $categorie = $entityManager->getRepository(Categorie::class);
        $listeCategorie = $categorie-> findAllCategorie();
        $localite = $entityManager->getRepository(Localite::class);
        $listeLocalite = $localite->findAllLocalite();
        $cp = $entityManager->getRepository(CodePostal::class);
        $listeCp= $cp->findAllCp();

        $form = $this->createForm(PrestataireSearchType::class);
        $form->handleRequest($request);

         //recuperation des donnees du prestataire connecte
        $prestataire = $entityManager->getRepository(Prestataire::class);
        $lePrestataire = $prestataire->findPrestataire($id);
        $logoName = $entityManager->getRepository(Image::class);
        $logoName = $logoName->findPicName($id);

        if(!empty($logoName)){
            $logoName = $logoName[0]['nom'];
        }else{
            $logoName = [];
        }

        //recuperation des donnees des catégories du prestataire connecte
        $requete = $entityManager->getRepository(Categorie::class);
        $userCategories = $requete->findCategoriePrestataire($id);

        //recuperation des donnees des stages du prestataire connecte
        $requete = $entityManager->getRepository(Stage::class);
        $userStages = $requete->findStagePrestataire($id);
       // dd($userStages);
        //recuperation des donnees des promotions du prestataire connecte
        $requete = $entityManager->getRepository(Promotion::class);
        $userPromotions = $requete->findPromotionPrestataire($id);

         if($lePrestataire[0]['bloque']==1 || $lePrestataire[0]['visible']==0 || $lePrestataire[0]['confirme']==0){
            return $this->redirectToRoute('app_logout');
         }
         if($role=='PRESTATAIRE'){
            $typeUser= 'prestataire';
        }else{
            $typeUser= 'remained';
         }

         // creation du cookie de connexion
        $cookie_name = "user";
        $cookie_value = $lePrestataire[0]['id'];
        setcookie($cookie_name, $cookie_value);


        // Obtention des 4 prestataires les plus récents
        $prestataire = $entityManager->getRepository(Prestataire::class);
        $listePrestataire = $prestataire->lastPrestataireInsert();
        $prestataireDatas = [];
        foreach ($listePrestataire as $data){
            $userImgData = [];
            $req = $entityManager->getRepository(Image::class);
            $listeImage = $req->findPicName($data->getId());
            $userImgData[] = $data;
            $userImgData[] = $listeImage[0]['nom'];
            $prestataireDatas[] = $userImgData;
        }
        //choix  d'un categorie aleatoire a afficher sur la page d'accueil
        //choix aléatoire d'une categorie
        $tailleCatehgories = count($listeCategorie);
        $random = rand(0,$tailleCatehgories-1);
        $categorieAleatoire = $listeCategorie[$random];
        // recuperation de l'image de la categorie
        $image = $entityManager->getRepository(Image::class);
        $categoryImage = $image->findCategoryPicName($categorieAleatoire->getId());

        // ternaire pour verifier si la categorie a une image
        $monImage = $categoryImage == null ? 'categorie.jpg' : $categoryImage[0]['nom'];
        $categorieChoisie  = [$categorieAleatoire,$monImage];


        return $this->renderForm('prestataire/profilPrestataire.html.twig', [
            'form' => $form,
            'commune'=>$listeCommune,
            'localite'=>$listeLocalite,
            'cp'=>$listeCp,
            'categorie'=> $listeCategorie,
            'userCategories'=>$userCategories,
            'categorieChoisie'=>$categorieChoisie,
            'userStages'=>$userStages,
            'userPromotions'=>$userPromotions,
            'prestataire'=>$lePrestataire[0],
            'prestataires'=>$prestataireDatas,
            'photo'=>$logoName,
            'typeUser'=>$typeUser,
            'infoBlock' => 'menuDeconnexion',

        ]);
    }
    /**
     * @Route("/user/description/prestataire/{id}", name="descriptionPrestataire")
     */
    public function descriptionPrestataire($typeInscription,Request $request,EntityManagerInterface $entityManager,MailerInterface $mailer,Environment $environment): Response
    {

        return $this->renderForm('inscription/index.html.twig', [

            'infoBlock' => 'menuConnexion',


        ]);
    }


}
