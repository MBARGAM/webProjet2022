<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Prestataire;
use App\Entity\Promotion;
use App\Form\PromotionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotioPromotionController extends AbstractController
{
    /**
     * @Route("/promotion/{id}", name="lesPromotions")
     */
    public function index($id,EntityManagerInterface $entityManager,Request $request): Response
    {
        $categories = $entityManager->getRepository(Categorie::class);
        $categories = $categories->findAllCategorie();

        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class,$promotion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //recuperation de l'objet Prestataire ayant rempli le formulaire
             $prestataire = $entityManager->getRepository(Prestataire::class);
             $prestataire = $prestataire->find($id);
             $data = $form->getData();
             //dd($data);
            //verification des champs
            if($data->getNom() != null && $data->getDescription() != null  ){
                $promotion->setPrestataire($prestataire);
                $promotion->setNom($data->getNom());
                $promotion->setDescription($data->getDescription());
                $promotion->setDebutAffichage($data->getDebutAffichage());
                $promotion->setFinAffichage($data->getFinAffichage());
                //dd($promotion);
                $entityManager->persist($promotion);
                $entityManager->flush();
            }

            return $this->redirectToRoute('lesStages', ['id' => $id]);
        }
        return $this->renderForm('promotio_promotion/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("user/promotion/{id}", name="promotionCourante")
     */
    public function stage($id,EntityManagerInterface $entityManager,Request $request): Response
    {

        return $this->renderForm('stage/index.html.twig', [

            'infoBlock' => 'menuConnexion',
        ]);
    }
}
