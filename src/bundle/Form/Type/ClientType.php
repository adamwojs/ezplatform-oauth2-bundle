<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Type;

use AdamWojs\EzPlatformOAuth2Bundle\Form\Data\ClientData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('identifier', TextType::class, [
            'disabled' => $options['update'],
        ]);
        $builder->add('secret', TextType::class);
        $builder->add('active', CheckboxType::class);

        $builder->add('redirectUris', CollectionType::class, [
            'allow_add' => true,
            'allow_delete' => true,
            'entry_type' => UrlType::class,
            'data' => [
                'https://',
            ],
        ]);

        $builder->add('grants', GrantChoiceType::class, [
            'expanded' => true,
            'multiple' => true,
        ]);

        $builder->add('scopes', ScopeChoiceType::class, [
            'expanded' => true,
            'multiple' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientData::class,
            'update' => false,
        ]);

        $resolver->setAllowedTypes('update', 'bool');
    }
}
