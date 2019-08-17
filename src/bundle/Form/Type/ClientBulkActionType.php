<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Type;

use AdamWojs\EzPlatformOAuth2Bundle\Form\Data\ClientSelectionData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientBulkActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('selection', CollectionType::class, [
            'required' => false,
            'prototype' => false,
            'entry_type' => ClientCheckboxType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'label' => false,
            'entry_options' => [
                'label' => false,
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientSelectionData::class,
        ]);
    }
}
