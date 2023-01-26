<?php

namespace App\Controller;

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
     * @Route("/promotion", name="lesPromotions")
     */
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class,$promotion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($promotion);
            $entityManager->flush();
            return $this->redirectToRoute('lesStages');
        }
        return $this->renderForm('promotio_promotion/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
        ]);
    }
}
