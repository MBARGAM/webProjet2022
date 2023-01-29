<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
