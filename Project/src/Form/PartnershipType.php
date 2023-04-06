<?php

namespace App\Form;

use App\Entity\Partnership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class PartnershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'disabled' => true,
                'attr' => [
                    'placeholder' => 'Nom du partenaire',
                    'class' => 'input-name form-input form-input-disabled'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => false,
                'disabled' => true,
                'attr' => [
                    'placeholder' => 'La description du partenaire',
                    'class' => 'input-description form-input form-input-disabled'
                ]
            ])
            ->add('link', TextType::class, [
                'disabled' => true,
                'required' => true,
                'label' => 'Lien du site : ',
                'attr' => [
                    'placeholder' => 'https://site_du_partenaire.fr',
                    'class' => 'form-input form-input-disabled'
                ]
            ])
            ->add('image', FileType::class, [
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
            'data_class' => Partnership::class,
        ]);
    }
}
