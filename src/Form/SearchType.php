<?php

namespace App\Form;

use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Localite;
use App\Entity\Prestataire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPrestataire',EntityType::class,[
                     'label'=> 'Prestataire',
                    'class'=> Prestataire::class,
                'choice_label'=> function($prestataire){
                     return $prestataire->getNom();
        }
            ])
        ->add('nomLocalite',EntityType::class,[
        'label'=> 'Localite',
        'class'=> Localite::class,
        'choice_label'=> function($localite){
            return $localite->getLocalite();
        }
       ])
            ->add('nomCommune',EntityType::class,[
                'label'=> 'Commune',
                'class'=> Commune::class,
                'choice_label'=> function($commune){
                    return $commune->getCommune();
                }
            ])
            ->add('cp',EntityType::class,[
                'label'=> 'Code postal',
                'class'=> CodePostal::class,
                'choice_label'=> function($codepostal){
                    return $codepostal->getCp();
                }
            ])
            ->add('submit',SubmitType::class,
                [
                    'label'=> "Go"

                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
