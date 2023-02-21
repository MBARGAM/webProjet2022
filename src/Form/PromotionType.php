<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description de votre promotion'
                ]

            ])
            ->add('categorie',EntityType::class,[
                'label'=> 'Catégorie',
                'class'=> Categorie::class,
                'choice_label'=> function($categorie){
                    return $categorie->getNom();
                }
            ])
            ->add('debutAffichage',DateType::class,[
                'label' => 'Début d\'affichage',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Début d\'affichage du stage'
                ]
            ])
            ->add('finAffichage',DateType::class,[
                'label' => 'Fin d\'affichage',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Fin d\'affichage du stage'
                ]
            ])
            ->add('document',FileType::class,[
                'label' => 'Document de promotion',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Choose a file pdf',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                           'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un PDF ',
                    ])
                ],
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Suivant',
                'attr' => [
                    'class' => 'btn btn-primary '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
