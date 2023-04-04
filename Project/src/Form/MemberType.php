<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Prénom",
                    'class' => 'form-input form-input-disabled'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Nom",
                    'class' => 'form-input form-input-disabled'
                ]
            ])
            ->add('function', TextType::class, [
                'label' => 'Fonction',
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'placeholder' => "Fonction",
                    'class' => 'form-input form-input-disabled'
                ]
            ])
            ->add('profil', FileType::class, [
                'label' => 'Choisir une image',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-file-input'
                ],
                'label_attr' => [
                    'class' => 'form-file-label form-file-label-disabled'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
