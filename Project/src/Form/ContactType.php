<?php

namespace App\Form\ContactType;

use Assert\Email;
use App\Entity\Contact;
use App\Entity\Subscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nameContact', TextType::class, [
                    'label' => 'Prénom',
                    'required'   => true,
                ])
                ->add('firstnameContact', TextType::class, [
                    'label' => 'Nom',
                    'required'   => true,
                ])
                ->add('emailContact', EmailType::class, [
                    'label' => 'Adresse mail',
                    'required'   => true,
                ])
                ->add('messageContact', TextareaType::class, [
                    'label' => 'Message',
                    'required'   => true,
                ])
                ->add('consentContact', CheckboxType::class, [
                    'label'    => 'J\'accepte que le site utilise mes informations personnelles ci-dessus afin de me contacter',
                    'required' => true,
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Envoyer mon message'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}