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
public function autofill($champ,$id,Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):Response
{
    var_dump($champ);
    switch ($champ){
        case "cp" :

            $commune = $entityManager->getRepository(Commune::class);
            $listeCommune = $commune-> findCommune($id);
            $localite = $entityManager->getRepository(Localite::class);
            $listeLocalite = $localite->findLocalite($id);

        break ;
        case "commune":

        break;

        case "localite":

        break;
    }
    var_dump($listeCommune);
    $listeLocalite= $serializer->serialize($listeLocalite,'json');

    return new JsonResponse($listeLocalite,200,[],true);
}





}
