<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Entity\Categorie;
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

            $categorie = new Categorie();
           // $categorie->addPrestataire($prestataire);
            $categorie->setNom($datas->getNom());
            $categorie->setDescription($datas->getDescription());
           $categorie->addPrestataire($prestataire);
            $categorie->setMisEnAvant(false);
            $categorie->setValidation(true);
//
            $entityManager->persist($categorie);

            $entityManager->flush();

            return $this->redirectToRoute('descriptionPrestataire', ['id' => $id ]);
        }
        return $this->renderForm('categorie/index.html.twig', [
            'form' => $form,
            'typeUser'=>'PRESTATAIRE',
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
