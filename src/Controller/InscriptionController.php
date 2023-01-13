<?php

namespace App\Controller;

use App\Entity\Internaute;
use App\Entity\Prestataire;
use App\Entity\Utilisateur;
use App\Form\PreinscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/preinscription/{typeInscription}", name="presignup")
     */

    public function preinscription($typeInscription,Request $request,EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(PreinscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            switch ($typeInscription) {
                case 'internaute':
                    // insertion du nom et prenom de l internaute et recuperation de l id pour insertion dans la table utilisateur
                    $internaute = new Internaute();
                    $internaute->setNom($data['nom']);
                    $internaute->setPrenom($data['prenom']);
                    $entityManager->persist($internaute);
                    $entityManager->flush();

                    //recuperation de l id de l internaute
                    $repository = $entityManager->getRepository(Internaute::class);
                    $lastPrestataireId = $repository->findLastId();
                    $lastPrestataireId = $lastPrestataireId[0]['id'];

                    // insertion de l email de l internaute et de l id de l internaute dans la table utilisateur
                    $utilisateur = new Utilisateur();
                    $utilisateur->setEmail($data['email']);
                    $utilisateur->setInternaute($lastPrestataireId);
                    $entityManager->persist($utilisateur);
                    $entityManager->flush();
                    break;

                case 'prestataire':
                    $prestataire = new Prestataire();
                    $prestataire->setNom($data['nom']);
                    $entityManager->persist($prestataire);
                    $entityManager->flush();

                    //recuperation de l id du prestataire
                    $repository = $entityManager->getRepository(Prestataire::class);
                    $lastPrestataireId = $repository->findLastId();
                    $lastPrestataireId = $lastPrestataireId[0]['id'];

                    // insertion de l email du prestataire et de l id de l internaute dans la table utilisateur
                    $utilisateur = new Utilisateur();
                    $utilisateur->setEmail($data['email']);
                    $utilisateur->setPrestataire($lastPrestataireId);
                    $entityManager->persist($utilisateur);
                    break;
            }

            return $this->redirectToRoute('envoiemail',['typeInscription'=>$typeInscription]);
        }

        return $this->renderForm('inscription/index.html.twig', [
            'form' => $form,
            'typeInscription'=>$typeInscription,
            'blockdisabled' => 'oui',
        ]);
    }
}
