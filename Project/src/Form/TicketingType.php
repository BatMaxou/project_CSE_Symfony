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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("id", HiddenType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Permanente' => 0,
                    'Limitée' => 1,
                ],
                'mapped' => false,
                'attr' => [
                    'class' => 'form-input'
                ],
            ])
            ->add('name', TextType::class, [
                'label' => "Nom :",
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Nom",
                    'class' => 'form-input'
                ],
            ])
            ->add('text', TextareaType::class, [
                'label' => "Description :",
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Description",
                    'class' => 'form-input'
                ],
            ])

            ->add('date_start', DateType::class, [
                'label' => "Date de début de validité :",
                'required' => true,
                'disabled' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input'
                ],
            ])
            ->add('date_end', DateType::class, [
                'label' => "Date de fin de validité :",
                'required' => true,
                'disabled' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input'
                ],
            ])
            ->add('number_min_place', IntegerType::class, [
                'label' => "Nombre de place minimum :",
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Nombre de place minimum",
                    'class' => 'form-input',
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
                    'class' => 'form-input'
                ],
            ])
            ->add('partnership', EntityType::class, [
                'class' => Partnership::class,
                'label' => 'Partenaire associé :',
                'choice_label' => 'name',
                'required' => false,
                'disabled' => true,
                'attr' => [
                    'class' => 'form-input'
                ],
            ])
            ->add('image1', FileType::class, [
                'label' => 'Choisir une image',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-file-input'
                ],
                'label_attr' => [
                    'class' => 'form-file-label form-file-label-disabled'
                ],
            ])
            ->add('image2', FileType::class, [
                'label' => 'Choisir une image',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-file-input'
                ],
                'label_attr' => [
                    'class' => 'form-file-label form-file-label-disabled'
                ],
            ])
            ->add('image3', FileType::class, [
                'label' => 'Choisir une image',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-file-input'
                ],
                'label_attr' => [
                    'class' => 'form-file-label form-file-label-disabled'
                ],
            ])
            ->add('image4', FileType::class, [
                'label' => 'Choisir une image',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-file-input'
                ],
                'label_attr' => [
                    'class' => 'form-file-label form-file-label-disabled'
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