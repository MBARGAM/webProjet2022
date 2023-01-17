<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Localite;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/accueil", name="pageAccueil")
     */
    public function search(Request $request,EntityManagerInterface $entityManager): Response
    {
        $commune = $entityManager->getRepository(Commune::class);
        $listeCommune = $commune-> findAllCommune();
        $categorie = $entityManager->getRepository(Categorie::class);
        $listeCategorie = $categorie-> findAllCategorie();
        $localite = $entityManager->getRepository(Localite::class);
        $listeLocalite = $localite->findAllLocalite();
        $cp = $entityManager->getRepository(CodePostal::class);
        $listeCp= $cp->findAllCp();

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
            'commune'=>$listeCommune,
            'localite'=>$listeLocalite,
            'cp'=>$listeCp,
          'categorie'=> $listeCategorie

        ]);
    }

     /**
      * @Route("accueil/{champ}/{id}", name="autocompletion" , methods="POST")
      */
    public function autofill($champ,$id,Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
     //switch case permet de rediriger vers la bonne fonction en fonction du du champ rempli
        switch ($champ){
            case "cp" :
              //  echo "le cp";
                $commune = $entityManager->getRepository(Commune::class);
                $listeCommune = $commune-> findCommune($id);
                $listeCommune = $serializer->serialize($listeCommune, 'json', [AbstractNormalizer::ATTRIBUTES => ['commune','id']]);
                $localite = $entityManager->getRepository(Localite::class);
                $listeLocalite = $localite->findLocalite($id);
                $listeLocalite= $serializer->serialize($listeLocalite,'json',[AbstractNormalizer:: ATTRIBUTES =>['localite','id']]);
                $result=['commune'=>$listeCommune,'localite'=>$listeLocalite];
                break ;
            case "commune":
                echo "cumune";
                die();
                $localite = $entityManager->getRepository(Localite::class);
                $listeLocalite = $localite->findLocalite($id);
                $listeLocalite= $serializer->serialize($listeLocalite,'json',[AbstractNormalizer:: ATTRIBUTES =>['localite','id']]);
                $cp = $entityManager->getRepository(CodePostal::class);
                $listeCp= $cp->findCp($id);
                $listeCp= $serializer->serialize($listeCp,'json',[AbstractNormalizer:: ATTRIBUTES =>['cp','id']]);
                $result=['localite'=>$listeLocalite,'cp'=>$listeCp];
                break;

            case "localite":
                echo "localite";
                die();
                $commune = $entityManager->getRepository(Commune::class);
                $listeCommune = $commune-> findCommune($id);
                $listeCommune = $serializer->serialize($listeCommune, 'json', [AbstractNormalizer::ATTRIBUTES => ['commune','id']]);
                $cp = $entityManager->getRepository(CodePostal::class);
                $listeCp= $cp->findCp($id);
                $listeCp= $serializer->serialize($listeCp,'json',[AbstractNormalizer:: ATTRIBUTES =>['cp','id']]);
                $result=['commune'=>$listeCommune,'cp'=>$listeCp];
                break;
        }
          return new JsonResponse($result);
    }

}
