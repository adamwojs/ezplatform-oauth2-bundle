<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Type;

use AdamWojs\EzPlatformOAuth2Bundle\Form\DataTransformer\ClientDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface;

final class ClientCheckboxType extends AbstractType
{
    /** @var \Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface */
    private $clientManager;

    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new ClientDataTransformer($this->clientManager));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
        ]);
    }
}
