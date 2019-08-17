<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ScopeChoiceType extends AbstractType
{
    /** @var string[] */
    private $scopes;

    public function __construct(array $scopes = [])
    {
        $this->scopes = $scopes;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => array_combine($this->scopes, $this->scopes),
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
