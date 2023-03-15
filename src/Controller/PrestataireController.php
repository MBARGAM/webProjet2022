<?php

namespace App\Controller;

use App\Classes\EmailSender;
use App\Classes\TokenCreation;
use App\Entity\Categorie;
use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Image;
use App\Entity\Localite;
use App\Entity\Prestataire;
use App\Entity\Promotion;
use App\Entity\Stage;
use App\Entity\Token;
use App\Classes\TokenClass;
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
    /*
          block permettant l'envoi d'un email de confirmation
            -recuperation des données qui seront envoyées dans le mail obtenues par le formulaire de preinscription
            - mise en  place de la classe EmailSender qui est dans le dossier Classes
            -recuperation du token qui sera envoyé dans le mail
       */
    public function sendEmail($email,$nom,$typeInscription ,$mailer, $environment,$token):void
    {
        $from = 'justyn7891@yahoo.fr';

        $to = $email;

        $subject = 'Confirmation de votre inscription';

        $message = 'Bonjour '. $nom . ' vous vous êtes pre-inscrit sur notre site';

        $template = 'envoi_email/prestataire.html.twig';

        //parametres allant dans le template
        $parametres = [

            'nom' => $nom,

            'email' => $email,

            'token' => $token,

            'typeInscription' => $typeInscription,
        ];

        $newEmail = new EmailSender($mailer, $environment);

        $newEmail->sendInscriptionEmail($to, $from, $subject, $message, $template, $parametres);
    }

    /*
     block traitant la preinscription du prestataire
        - récuperation des données du formulaire de preinscription
       - creation d'un token et insertion dans la base de données
       - envoi d'un email de confirmation
       - redirection vers la page d'accueil
       - affchahe du formulaire de preinscription si pas complété
   */

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

            //creation d'un  d un token et insertion dans la base de données
            $newToken = new TokenCreation();

            $token = new Token();

            $token->setNom($newToken->generateToken());

            $entityManager->persist($token);

            $entityManager->flush();

            //envoi d'un email de confirmation
            $this->sendEmail($data['email'],$data['nom'],$typeInscription,$mailer,$environment,$token->getNom());

            return $this->redirectToRoute('monAccueil',["prenom"=>$data['nom']]);
        }

        return $this->renderForm('inscription/index.html.twig', [

            'form' => $form,

            'typeInscription'=>$typeInscription,

            'categorie'=> $listeCategorie,

        ]);
    }


    /*
     block traitant le traitement de l'inscription du prestataire
        - recuperation des données du formulaire d' inscription
        - insertion dans la base de données
        - redirection vers la page d'accueil
   */
    /**
     * @Route("/inscriptionPrestataire/{nom}/{typeInscription}/{email}", name="formulairePrestataire" , methods={"GET","POST"})
     */

    public function inscriptionPrestataire($nom,$typeInscription,$email,Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();

        $form=$this->createForm(LoginPrestatataireType::class);

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
            //insertion dans la table prestataire
            $prestataire = new Prestataire();

            $prestataire->setNom(strtolower($data['nom']));

            $prestataire->setDescription(strtolower($data['description']));

            $prestataire->setSiteweb(strtolower($data['siteweb']));

            $prestataire->addCategorie($data['categorie']);

            $prestataire->setNumeroTva(strtolower($data['tva']));

            $prestataire->setTel(strtolower($data['tel']));

            $prestataire->setBloque(0);

         //  dd($prestataire);
            $entityManager->persist($prestataire);

            $entityManager->flush();

            //recuperation de l'id du prestataire pour les images les stages et les promotions
            $lastId = $prestataire->getId();

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

            'categorie'=> $listeCategorie,

            'typeInscription'=>$typeInscription,

            'nom'=>$nom,

            'email'=>$email,
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

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $idCategorie = $data["categorie"]->getId();

            $idLocalite = $data["nomLocalite"]->getId();

            $idCommune = $data["nomCommune"]->getId();

            $idCp = $data["cp"]->getId();

            $nomPrestataire  =  $data["nomPrestataire"] == null ? 'null' : $data["nomPrestataire"];

            return $this->redirectToRoute('search', [
                'idCategorie' => $idCategorie,

                'idLocalite' => $idLocalite,

                'idCommune' => $idCommune,

                'idCp' => $idCp,

                'NoPage'=> 1,

                'nomPrestataire' => $nomPrestataire
            ]);
        }

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

        //recuperation des donnees des promotions du prestataire connecte
        $requete = $entityManager->getRepository(Promotion::class);

        $userPromotions = $requete->findPromotionPrestataire($id);

         if($lePrestataire[0]['bloque']==1 || $lePrestataire[0]['visible']==0 || $lePrestataire[0]['confirme']==0){
            return $this->redirectToRoute('app_logout');
         }
         if($role=='PRESTATAIRE'){

            $typeUser= 'PRESTATAIRE';

        }else{

            $typeUser= 'INTERNAUTE';
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

        // recuperation de la categorie choisie par la prestataire

        $req = $entityManager->getRepository(Categorie::class);

        $categorieChoisie= $req->findCategorieChoisie();

        $categorieChoisie = $categorieChoisie[0];

        $img =$categorieChoisie->getImage() == null  ? null : $categorieChoisie->getImage()->getNom();


        $monImage = $img == null ? 'categorie.jpg' : $img;

        $categorieChoisie  = [$categorieChoisie,$monImage];


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

        ]);
    }


    /**
     * @Route("/user/description/prestataire/{id}", name="descriptionPrestataire")
     */
    public function descriptionPrestataire($id,Request $request,EntityManagerInterface $entityManager): Response
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

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $idCategorie = $data["categorie"]->getId();

            $idLocalite = $data["nomLocalite"]->getId();

            $idCommune = $data["nomCommune"]->getId();

            $idCp = $data["cp"]->getId();

            $nomPrestataire  =  $data["nomPrestataire"] == null ? 'null' : $data["nomPrestataire"];

            return $this->redirectToRoute('search', [
                'idCategorie' => $idCategorie,
                'idLocalite' => $idLocalite,
                'idCommune' => $idCommune,
                'idCp' => $idCp,
                'NoPage'=> 1,
                'nomPrestataire' => $nomPrestataire
            ]);
        }
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

        //recuperation des donnees des promotions du prestataire connecte
        $requete = $entityManager->getRepository(Promotion::class);

        $userPromotions = $requete->findPromotionPrestataire($id);


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

        // recuperation de la categorie choisie par la prestataire

        $req = $entityManager->getRepository(Categorie::class);

        $categorieChoisie= $req->findCategorieChoisie();

        $categorieChoisie = $categorieChoisie[0];

        $img =$categorieChoisie->getImage() == null  ? null : $categorieChoisie->getImage()->getNom();


        $monImage = $img == null ? 'categorie.jpg' : $img;

        $categorieChoisie  = [$categorieChoisie,$monImage];

        return $this->renderForm('prestataire/prestataireCourant.html.twig', [

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

        ]);


    }


}
