<?php

namespace App\Controller;

use App\Form\PrestatairePreinnscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestataireController extends AbstractController
{
    /**
     * @Route("/prestataire/{typeInscription}", name="presignupPrestataire")
     */

    public function preinscriptionPrestataire($typeInscription,Request $request,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrestatairePreinnscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            return $this->redirectToRoute('envoiMailInternaute',[
                'nom' => $data['nom'],
                'email' =>$data['email'],
                'typeInscription'=>$typeInscription
            ]);
        }

        return $this->renderForm('inscription/index.html.twig', [
            'form' => $form,
            'typeInscription'=>$typeInscription,
            'blockdisabled' => 'oui',
        ]);
    }

}
