<?php

namespace App\Form;

use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Internaute;
use App\Entity\Localite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternauteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('prenom',TextType::class,[
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'example@monsite.be'
                ]
            ])

            ->add('numero',IntegerType::class,[
                'label' => 'Numéro de maison',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => '123'
                ]
            ])
            ->add('adresse',TextType::class,[
                'label' => 'Adresse',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: Rue de la joie'
                ]
            ])
            ->add('codepostal',EntityType::class,[
                'label' => 'Code postal',
                'mapped' => false,
                'required' => true,
                'class' => CodePostal::class,
                'choice_label' =>  function($codePostal){
                    return $codePostal->getCp();
                }
            ])
            ->add('commune',EntityType::class,[
                'label' => 'Commune',
                'mapped' => false,
                'required' => true,
                'class'=>Commune::class,
                'choice_label' => function($commune){
                    return $commune->getCommune();
                }
            ])

            ->add('province',EntityType::class,[
                'label' => 'Province',
                'mapped' => false,
                'required' => true,
                'class' => Localite::class,
                'choice_label' => function($localite){
                    return $localite->getLocalite();
                }
            ])

            ->add('newsletter',CheckboxType::class,[
                'label' => 'Newsletter',
                'required' => false,
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
            'data_class' => Internaute::class,
        ]);
    }
}
