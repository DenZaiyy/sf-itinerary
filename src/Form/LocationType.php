<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'help' => 'Please enter a name',
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
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
                'required' => true,
                'help' => 'Please enter a latitude',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude',
                'required' => true,
                'help' => 'Please enter a longitude',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'required' => true,
                'help' => 'Please enter an address',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create',
                'attr' => [
                    'class' => "p-2 bg-blue-500 text-white rounded-md w-full"
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
