<?php

namespace App\Controller;


use App\Classes\FileLoader;
use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageController extends AbstractController
{
    /**
     * @Route("/image", name="lesImages")
     */
    public function index(EntityManagerInterface $entityManager,Request $request,SluggerInterface $slugger): Response
    {


        $form = $this->createForm(ImageType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $logoFile = $form->get('logo')->getData();
            $photoFile = $form->get('photo')->getData();
            //instantiate the class Image
            $fileLoader = new FileLoader($slugger);
            $logo = $fileLoader->upload($logoFile);

            $image = new Image();
            $image->setPhoto($logo);
            dd($logo);



            die();
            $entityManager->persist($image);
            $entityManager->flush();
            return $this->redirectToRoute('lesPromotions', ['id' => "moi"]);
        }
        return $this->renderForm('image/index.html.twig', [
            'form' => $form,
            'infoBlock' => 'menuConnexion',
        ]);
    }
}
