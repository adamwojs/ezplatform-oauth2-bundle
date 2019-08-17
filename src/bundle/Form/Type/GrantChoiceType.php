<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trikoder\Bundle\OAuth2Bundle\OAuth2Grants;

final class GrantChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => $this->getAvailableChoices(),
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    private function getAvailableChoices(): array
    {
        $choices = [
            OAuth2Grants::AUTHORIZATION_CODE,
            OAuth2Grants::CLIENT_CREDENTIALS,
            OAuth2Grants::IMPLICIT,
            OAuth2Grants::PASSWORD,
            OAuth2Grants::REFRESH_TOKEN,
        ];

        return array_combine($choices, $choices);
    }
}
