<?php

namespace App\Form\PartnershipType;

use App\Entity\Partnership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PartnershipType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partnership::class,
        ]);
    }
}
