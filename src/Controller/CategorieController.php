<?php

namespace App\Controller;

use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/user/ajout/categorie/{id}", name="ajouterCategorie")
     */
    public function ajouterCategorie($id,EntityManagerInterface $entityManager,Request $request): Response
    {
        $form = $this->createForm(CategorieType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('profilPrestataire', ['id' => $id]);
        }
        return $this->renderForm('categorie/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuDeconnexion',
        ]);
    }
    /**
     * @Route("/user/categorie/{id}", name="categorieCourante")
     */
    public function index($id,EntityManagerInterface $entityManager,Request $request): Response
    {
        $form = $this->createForm(CategorieType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            dd($data);
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('profilPrestataire', ['id' => $id]);
        }
        return $this->renderForm('categorie/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuDeconnexion',
        ]);
    }
}
