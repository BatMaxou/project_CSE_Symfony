<?php

namespace App\Form;

use App\Entity\ImageTicketing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketingLimitedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("id", HiddenType::class)
            ->add('name', TextType::class, [
                'label' => "Choisir une image :",
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'class' => 'form-input form-input-disabled'
                ],
            ])
            ->add('idTicketing', HiddenType::class, [
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
            'data_class' => ImageTicketing::class,
        ]);
    }
}