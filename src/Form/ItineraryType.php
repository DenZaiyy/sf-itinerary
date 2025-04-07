<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('locations', CollectionType::class, [
                'entry_type' => LocationItineraryType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'p-2 border border-gray-300 rounded-md w-full'
                    ],
                    'locations_choices' => $options['locations_choices'],
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'by_reference' => false,
                'help' => 'Please enter locations',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'data-controller' => 'form-collection',
                    'data-form-collection-add-label-value' => 'Ajouter une location',
                    'data-form-collection-delete-label-value' => 'Supprimer la location',
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
            'data_class' => null,
            'locations_choices' => []
        ]);
    }
}
