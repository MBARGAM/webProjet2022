<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image", name="lesImages")
     */
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($image);
            $entityManager->flush();
            return $this->redirectToRoute('lesPromotions');
        }
        return $this->renderForm('image/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
        ]);
    }
}
