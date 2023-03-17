<?php

namespace App\Form\UserResponseType;

use App\Entity\UserResponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserResponseType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserResponse::class,
        ]);
    }
}
