<?php

namespace App\Form;

use App\Entity\Survey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("id", HiddenType::class)
            ->add('question', TextType::class, [
                'label' => 'Question',
                'required' => true,
                'attr' => [
                    'placeholder' => "Question",
                    'class' => 'form-input'
                ]
            ])
            ->add('response_1', TextType::class, [
                'label' => 'Réponse 2',
                'required' => true,
                'attr' => [
                    'placeholder' => "Réponse 1",
                    'class' => 'form-input'
                ]
            ])
            ->add('response_2', TextType::class, [
                'label' => 'Réponse 1',
                'required' => true,
                'attr' => [
                    'placeholder' => "Réponse 2",
                    'class' => 'form-input'
                ]
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Désigner ce sondage comme actif'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }
}
