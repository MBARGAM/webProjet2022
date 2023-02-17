<?php

namespace App\Controller;

use App\Classes\Adresses;
use App\Entity\Categorie;
use App\Entity\Prestataire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    /**
     * @Route("/adresse", name="app_adresse")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $data = new Adresses();

        /*debut insertion des codes postaux
                  $codePostaux = $data::cp();
                  foreach ($codePostaux as $key=>$value){
                    $newCp = new CodePostal();
                    $newCp->setCp($value);
                    $entityManager->persist($newCp);
                    $entityManager->flush();
                }
        fin insertion des  code postaux */
        /* debut insertion des commune
                $cpRepository = $entityManager->getRepository(CodePostal::class);
                 $listeCp = $cpRepository->findAll();
                $commune =$data::commune($listeCp);
               $commune =  array_slice($commune, 1459);

                foreach ($commune as $key=>$value){
                    $commune= new Commune();
                    $commune->setCp($value->getCp());
                    $commune->setCommune($value->getCommune());
                    $entityManager->persist($commune);
                    $entityManager->flush();
                }
         fin de l insertion des communes */
        /* debut insertion des commune
             $cpRepository = $entityManager->getRepository(CodePostal::class);
             $listeCp = $cpRepository->findAll();
             $localite =$data::localite($listeCp);
             $localite = array_slice($localite, 2355);
            // dd($localite);
             foreach ($localite as $key=>$value) {
                 $localite = new Localite();
                 $localite->setCp($value->getCp());
                 $localite->setLocalite($value->getLocalite());
                 $localite->setCommune($value->getCommune());
                 $entityManager->persist($localite);
                 $entityManager->flush();
             }
      fin de l insertion des localite */
        return $this->redirectToRoute('pageAccueil');
    }



}
