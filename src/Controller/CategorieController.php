<?php

namespace App\Controller;

use App\Classes\FileLoader;
use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Image;
use App\Entity\Localite;
use App\Entity\Prestataire;
use App\Entity\Categorie;
use App\Entity\Promotion;
use App\Entity\Stage;
use App\Form\CategorieType;
use App\Form\PrestataireSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorieController extends AbstractController
{
    /*
      block de traitement d un nouvel ajout d une categorie
      -recuperation des donnees du formulaire
      - traitement de l image de la categorie
      - insertion de la categorie dans la base de donnees
   */
    /**
     * @Route("/user/ajout/categorie/{role}/{id}", name="ajouterCategorie")
     */
    public function ajouterCategorie($id,$role,EntityManagerInterface $entityManager,Request $request,SluggerInterface $slugger): Response
    {
        // cette fontion gere l insertion d un categorie par soit admin ou prestataire
        $form = $this->createForm(CategorieType::class);

        $form->handleRequest($request);

       $data = $entityManager->getRepository(Prestataire::class)->findPrestataire($id);

        $prestataire = new Prestataire();

        $prestataire->setId($id);

        $prestataire->setNom(strtolower($data[0]['nom']));

        $prestataire->setSiteweb(strtolower($data[0]['site']));

        $prestataire->setDescription(strtolower($data[0]['description']));

        $prestataire->setNumeroTva(strtolower($data[0]['NoTVA']));

        $prestataire->setTel(strtolower($data[0]['tel']));

        $prestataire->setBloque($data[0]['bloque']);

        if($form->isSubmitted() && $form->isValid()){

            $datas = $form->getData();

            // traitement de l'image de la categorie et insertion dans la base de données
            $categorie = new Categorie();

            $categorie->setNom($datas->getNom());

            $categorie->setDescription($datas->getDescription());

            $categorie->setMisEnAvant(false);

            // verification du role de celui qui ajoute  la categorie
            if($role == 'PRESTATAIRE'){

                $categorie->setValidation(false);

                $entityManager->persist($categorie);

                $entityManager->flush();

                $categorieFile = $form->get('photo')->getData();

                if($categorieFile != null){

                    $fileLoader = new FileLoader($slugger);

                    $logo = $fileLoader->uploadCategorie($categorieFile);

                    $image = new Image();

                    $image->setNom($logo);

                    $image->setCategorie($categorie);

                    $entityManager->persist($image);

                    $entityManager->flush();
                }

                return $this->redirectToRoute('profilPrestataire', ['id' => $id, 'role' => $role ]);

            }else if ($role == 'ADMIN'){

                $categorie->setValidation(true);

                $entityManager->persist($categorie);

                $entityManager->flush();

                $categorieFile = $form->get('photo')->getData();

                if($categorieFile != null){

                    $fileLoader = new FileLoader($slugger);

                    $logo = $fileLoader->uploadCategorie($categorieFile);

                    $image = new Image();

                    $image->setNom($logo);

                    $image->setCategorie($categorie);

                    $entityManager->persist($image);

                    $entityManager->flush();
                }

                return $this->redirectToRoute('descriptionPrestataire', ['id' => $id ]);
            }

        }
        return $this->renderForm('categorie/index.html.twig', [

            'form' => $form,

            'typeUser'=>'PRESTATAIRE',

        ]);
    }

    /*
     block de traitement d une categorie
     -recherche des infos en base de donnee
     - affichage
    */
    /**
     * @Route("/user/categorie/{id}", name="categorieCourante")
     */
    public function index($id,EntityManagerInterface $entityManager,Request $request): Response
    {

        // gestion de la page categorie courante
        $commune = $entityManager->getRepository(Commune::class);

        $listeCommune = $commune-> findAllCommune();//liste des communes

        $categorie = $entityManager->getRepository(Categorie::class);

        $listeCategorie = $categorie-> findAllCategorie();//liste des categories

        $categorieCourante = $categorie->findCategorie($id);

        $image = $entityManager->getRepository(Image::class);

        $imageCourante = $image->findCategoriePicName($categorieCourante[0]->getId());//nom de l'image de la categorie courante

        $localite = $entityManager->getRepository(Localite::class);

        $listeLocalite = $localite->findAllLocalite();//

        $cp = $entityManager->getRepository(CodePostal::class);

        $listeCp= $cp->findAllCp();//liste des codes postaux

        $prestatairesDeLaCategorie = $entityManager->getRepository(Prestataire::class);

        $listePrestataire = $prestatairesDeLaCategorie ->findCategoriePrestataire($categorieCourante[0]->getId());


        $form = $this->createForm(PrestataireSearchType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $idCategorie =  $data["categorie"] == null ? 'null' : $data["categorie"]->getId();

            $idLocalite = $data["nomLocalite"]== null ? 'null' : $data["nomLocalite"]->getId();

            $idCommune = $data["nomCommune"]== null ? 'null' : $data["nomCommune"]->getId();

            $idCp = $data["cp"]== null ? 'null' : $data["cp"]->getId();

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
       /* verification de l existence de l image de la categorie courante si elle a ete telechargee
       et si l image n est pas charge au prealable on alloue une image par defaut */


        $limage = empty($imageCourante) ? 'categorie.jpg' : $imageCourante[0]['nom'];

        // Obtention des 4 prestataires les plus récents
        $prestataire = $entityManager->getRepository(Prestataire::class);

        $listePrestataires = $prestataire->lastPrestataireInsert();

        if ($listePrestataires != null){

            $prestataireDatas = [];

            foreach ($listePrestataires as $data){

                $userImgData = [];

                $req = $entityManager->getRepository(Image::class);

                $listeImage = $req->findPicName($data->getId());

                if($listeImage != null){

                    $userImgData[] = $data;

                    $userImgData[] = $listeImage[0]['nom'];

                    $prestataireDatas[] = $userImgData;

                }else{

                    $prestataireDatas[] = $userImgData;

                }
            }
        }else{

            $prestataireDatas = null;
        }

        // recuperation de la categorie choisie par la prestataire

        $req = $entityManager->getRepository(Categorie::class);

        $categorieChoisie= $req->findCategorieChoisie();

        if($categorieChoisie == null){

            $monImage =  'categorie.jpg';

            $categorieChoisie  = ["null",$monImage];
        }
        else{

            $categorieChoisie = $categorieChoisie[0];

            $img =$categorieChoisie->getImage() == null  ? null : $categorieChoisie->getImage()->getNom();

            $monImage = $img == null ? 'categorie.jpg' : $img;

            $categorieChoisie  = [$categorieChoisie,$monImage];
        }


        return $this->renderForm('categorie/categorieCourante.html.twig', [

            'form' => $form,

            'commune'=>$listeCommune,

            'localite'=>$listeLocalite,

            'cp'=>$listeCp,

            'categorie'=> $listeCategorie,

            'categorieCourante' => $categorieCourante[0],

            'nomImage'=> $limage,

            'mesprestataires' => $listePrestataire,

            'prestataires'=>$prestataireDatas,

            'categorieChoisie'=>$categorieChoisie,
        ]);

    }
}