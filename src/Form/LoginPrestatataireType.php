<?php

namespace App\Form;

use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Localite;
use App\Entity\Promotion;
use App\Entity\Stage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginPrestatataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'required' => true,

            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'example@monsite.be'
                ]
            ])
            ->add('mdp',PasswordType::class,[
                'label' => 'Mot de passe',
                'required' => true,
                'attr' => [
                    'placeholder' => '7-15 caractères , lettres , chiffres , min 1 caractère spécial'
                ]
            ])
            ->add('tel',TextType::class,[
                'label' => 'Téléphone',
                'required' => true,
                'attr' => [
                    'placeholder' => 'example@monsite.be'
                ]
            ])

            ->add('numero',TextType::class,[
                'label' => 'Numéro de maison',
                'required' => true,
                'attr' => [
                    'placeholder' => '123'
                ]
            ])
            ->add('adresse',TextType::class,[
                'label' => 'Adresse',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: Rue de la joie'
                ]
            ])
            ->add('codepostal',EntityType::class,[
                'label' => 'Code postal',
                'required' => true,
                'class' => CodePostal::class,
                'choice_label' =>  function($codePostal){
                    return $codePostal->getCp();
                }
            ])
            ->add('commune',EntityType::class,[
                'label' => 'Commune',
                'required' => true,
                'class'=>Commune::class,
                'choice_label' => function($commune){
                    return $commune->getCommune();
                }
            ])

            ->add('province',EntityType::class,[
                'label' => 'Province',
                'required' => true,
                'class' => Localite::class,
                'choice_label' => function($localite){
                    return $localite->getLocalite();
                }
            ])
            ->add('tva',TextType::class,[
                'label' => 'N° de TVA',
                'required' => true,
            ])

            ->add('siteweb',TextType::class,[
                'label' => 'Site internet',
                'required' => true,
                'attr' => [
                    'placeholder' => 'www.monsite.be'
                ]
            ])
            ->add('stage',EntityType::class,[
                'label' => 'Stages',
                'class' => Stage::class,
                'choice_label' => function($stage){
                    return $stage->getStage();
                }
            ])
            ->add('promotion',EntityType::class,[
                'label' => 'Promotions',
                'class' =>Promotion::class,
                'choice_label' => function($promotion){
                    return $promotion->getPromotion();
                }
            ])

            ->add('submit',SubmitType::class,[
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
