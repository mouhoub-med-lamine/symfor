<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'nom d\'ingredient','class' => 'form-input form-control-has-validation'],
                'label' => 'Nom de l\'ingrédient',
                'label_attr' => ['class' => 'form-label rd-input-label'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => ['placeholder' => 'prix','class' => 'form-input form-control-has-validation'],
        
                'label' => 'prix',
                'label_attr' => ['class' => 'form-label rd-input-label'],
                'constraints' => [
                ]
            ])
            ->add('rating', ChoiceType::class, [
                'attr' => ['class' => 'form-input form-control-has-validation'],
                'label' => 'Votes ...',
                'label_attr' => ['class' => 'form-label rd-input-label'],
                'choices' => [
                    '1 étoile' => 1,
                    '2 étoiles' => 2,
                    '3 étoiles' => 3,
                    '4 étoiles' => 4,
                    '5 étoiles' => 5,
                ],
                'placeholder' => 'Sélectionnez une note',  // Optionnel : pour ajouter une valeur par défaut
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 5,
                        'minMessage' => 'Le rating doit être d\'au moins {{ limit }}.',
                        'maxMessage' => 'Le rating ne peut pas dépasser {{ limit }}.'
                    ]),
                ],
            ])
            ->add('submit' , SubmitType::class , [
                'attr' => ['class' => 'button button-lg button-primary button-winona wow fadeInRight mt-4 mr-auto ml-auto'],
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
