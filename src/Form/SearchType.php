<?php

namespace App\Form;

use App\Entity\Categorie;
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
            ->add('nomPrestataire',TextType::class,[
                'label'=> 'Prestataire',
                'required' => true,
                // changer error message par défaut
                'invalid_message' => 'Veuillez saisir un nom',
                'attr' => [
                    'placeholder' => 'Nom du prestataire'
                ]])

        ->add('nomLocalite',EntityType::class,[
        'label'=> 'Province',
        'class'=> Localite::class,
        'choice_label'=> function($localite){
            return $localite->getLocalite();
        }

       ])
            ->add('categorie',EntityType::class,[
                'label'=> 'Catégorie',
                'class'=> Categorie::class,
                'choice_label'=> function($categorie){
                    return $categorie->getNom();
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
                'label'=> 'C.P.',
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
