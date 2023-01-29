<?php

namespace App\Controller;

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
     * @Route("/stage", name="lesStages")
     */
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class,$stage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $form->getData();
            dd($stage);

            $entityManager->persist($stage);
            $entityManager->flush();
            return $this->redirectToRoute('pageAccueil');
        }

        return $this->renderForm('stage/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
        ]);
    }
}
