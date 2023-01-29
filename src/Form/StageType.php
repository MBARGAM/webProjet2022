<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom du stage'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description du stage'
                ]
            ])
            ->add('tarif',MoneyType::class,[
                'label' => 'Tarif',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Tarif du stage'
                ]
            ])
            ->add('infosComplementaires',TextareaType::class,[
                'label' => 'Informations complémentaires',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Informations complémentaires'
                ]
            ])
            ->add('dateDebut',DateType::class,[
                'label' => 'Date de début',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Date de début du stage'
                ]
            ])
            ->add('dateFin',DateType::class,[
                'label' => 'Date de fin',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Date de fin du stage'
                ]
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
            ->add('submit',SubmitType::class,[
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary '
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
