<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true,
                'help' => 'Please enter a title',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'help' => 'Please enter a description',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create Itinerary',
                'attr' => [
                    'class' => 'p-2 bg-blue-500 text-white rounded-md w-full'
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
