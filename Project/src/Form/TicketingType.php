<?php

namespace App\Form;

use App\Entity\Ticketing;
use App\Entity\Partnership;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("id", HiddenType::class)
            ->add('name', TextType::class, [
                'label' => "Nom :",
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Nom",
                    'class' => 'form-input form-input-disabled'
                ],
            ])
            ->add('text', TextareaType::class, [
                'label' => "Description :",
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Description",
                    'class' => 'form-input form-input-disabled'
                ],
            ])

            ->add('date_start', DateType::class, [
                'label' => "Date de début de validité :",
                'required' => true,
                'disabled' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input form-input-disabled'
                ],
            ])
            ->add('date_end', DateType::class, [
                'label' => "Date de fin de validité :",
                'required' => true,
                'disabled' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input form-input-disabled'
                ],
            ])
            ->add('number_min_place', IntegerType::class, [
                'label' => "Nombre de place minimum :",
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Nombre de place minimum",
                    'class' => 'form-input form-input-disabled',
                    'min' => '0'
                ],
            ])
            ->add('order_number', ChoiceType::class, [
                'choices' => [
                    'Ne pas apparaître' => 0,
                    'Numéro 1' => 1,
                    'Numéro 2' => 2,
                    'Numéro 3' => 3,
                    'Numéro 4' => 4,
                    'Numéro 5' => 5,
                    'Numéro 6' => 6,
                    'Numéro 7' => 7,
                    'Numéro 8' => 8,
                    'Numéro 9' => 9,
                    'Numéro 10' => 10,
                ],
                'mapped' => false,
                'label' => 'Ordre d\'affichage :',
                'disabled' => true,
                'attr' => [
                    'class' => 'form-input form-input-disabled'
                ],
            ])
            ->add('partnership', EntityType::class, [
                'class' => Partnership::class,
                'label' => 'Partenaire associé :',
                'choice_label' => 'name',
                'required' => false,
                'disabled' => true,
                'attr' => [
                    'class' => 'form-input form-input-disabled'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticketing::class,
        ]);
    }
}