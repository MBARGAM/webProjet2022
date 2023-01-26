<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du stage'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description du stage'
                ]

            ])
            ->add('tarif',IntegerType::class,[
                'label' => 'Tarif',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Tarif du stage'
                ]

            ])
            ->add('infosComplementaires',TextareaType::class,[
                'label' => 'Informations complémentaires',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Informations complémentaires'
                ]

            ])
            ->add('dateDebut',DateTimeType::class,[
                'label' => 'Date de début',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Date de début du stage'
                ]

            ])
            ->add('dateFin',DateTimeType::class,[
                'label' => 'Date de fin',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Date de fin du stage'
                ]

            ])
            ->add('debutAffichage',DateTimeType::class,[
                'label' => 'Début d\'affichage',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Début d\'affichage du stage'
                ]

            ])
            ->add('finAffichage',DateTimeType::class,[
                'label' => 'Fin d\'affichage',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Fin d\'affichage du stage'
                ]

            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Soumettre',
                'attr' => [
                    'class' => 'btn '
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
