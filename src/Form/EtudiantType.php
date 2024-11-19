<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'M',
                    'Féminin' => 'F',
                ],
            ])
            ->add('classe', ChoiceType::class, [
                'choices' => [
                    'Classe 1' => 'classe_1',
                    'Classe 2' => 'classe_2',
                ],
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Photo',
                'mapped' => true, // Champ lié à la propriété `image` de l'entité
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}