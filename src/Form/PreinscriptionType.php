<?php

namespace App\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreinscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=> 'Nom',
                'attr'=>[
                    'placeholder'=> 'Saississez votre nom'
                ]

            ])
            ->add('prenom',TextType::class,[
                'label'=> 'Prénom',
                'attr'=>[
                    'placeholder'=> 'Saississez votre prenom'
                ]

            ])
            ->add('email',EmailType::class,[
                'label'=> 'Email',
                'attr'=>[
                    'placeholder'=> 'Saississez votre email'
                ]

            ])
            ->add('submit',SubmitType::class,[
                'label'=> 'Soumettre',

            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
