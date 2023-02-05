<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Entity\Stage;
use App\Form\StageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends AbstractController
{
    /**
     * @Route("/stage/{id}", name="lesStages")
     */
    public function index($id,EntityManagerInterface $entityManager,Request $request): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class,$stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //recuperation de l'objet Prestataire ayant rempli le formulaire
            $prestataire = $entityManager->getRepository(Prestataire::class);
            $prestataire = $prestataire->find($id);

            $data= $form->getData();
;
            //verification des champs

            if($data->getNom() != null && $data->getDescription() != null  && $data->getTarif() != null && $data->getInfosComplementaires() != null){
                $stage->setPrestataire($prestataire);
                $stage->setNom($data->getNom());
                $stage->setDescription($data->getDescription());
                $stage->setTarif($data->getTarif());
                $stage->setInfosComplementaires($data->getInfosComplementaires());
                $stage->setDateDebut($data->getDateDebut());
                $stage->setDateFin($data->getDateFin());
                $stage->setDateDebut($data->getDateDebut());
                $stage->setDateFin($data->getDateFin());
                $stage->setDateCreation(new \DateTime());
                //dd($stage);
                $entityManager->persist($stage);
                $entityManager->flush();
            }
            return $this->redirectToRoute('pageAccueil');
        }

        return $this->renderForm('stage/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
        ]);
    }

    /**
     * @Route("user/stage/{id}", name="stageCourant")
     */
    public function stage($id,EntityManagerInterface $entityManager,Request $request): Response
    {

        return $this->renderForm('stage/index.html.twig', [

            'infoBlock' => 'menuConnexion',
        ]);
    }

}
