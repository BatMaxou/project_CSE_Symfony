<?php

namespace App\Form;

use App\Entity\Ckeditor;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TextsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', CKEditorType::class, [
                'label' => 'Mail',
                'required' => true,
            ])
            ->add('homepage', CKEditorType::class, [
                'label' => 'Texte de présentation',
                'required' => true,
            ])
            ->add('actions', CKEditorType::class, [
                'label' => 'Actions menées',
                'required' => true,
            ])
            ->add('rules', CKEditorType::class, [
                'label' => 'Règlement',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CKeditor::class,
        ]);
    }
}
