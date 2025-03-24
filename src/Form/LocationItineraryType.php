<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        //dd(array_values($options['data']));

        $builder
            ->add('location', ChoiceType::class, [
                'label' => 'Location',
                'choices' => $options['locations_choices'],
                'required' => true,
                'help' => 'Please enter a name',
                'help_attr' => [
                    'class' => 'text-sm text-gray-500'
                ],
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('order', NumberType::class, [
                'label' => 'Order',
                'help' => 'Please enter a number',
                'required' => true,
                'attr' => [
                    'class' => 'p-2 border border-gray-300 rounded-md w-full'
                ]
            ])
            ->add('mustToSee', CheckboxType::class, [
                'label' => 'Must to see',
                'required' => false,
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
