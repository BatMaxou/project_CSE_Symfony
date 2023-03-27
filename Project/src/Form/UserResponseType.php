<?php

namespace App\Form;

use App\Entity\UserResponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserResponseType extends AbstractType
{
    // plutot faire un survey type
    // find survey id active
    // find response by syrvey id
    // foreach create input radio

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserResponse::class,
        ]);
    }
}
