<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;

final class ClientDataTransformer implements DataTransformerInterface
{
    /** @var \Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface */
    private $clientManager;

    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    public function transform($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!($value instanceof Client)) {
            throw new TransformationFailedException();
        }

        return $value->getIdentifier();
    }

    public function reverseTransform($value): ?Client
    {
        if ($value === null) {
            return null;
        }

        $client = $this->clientManager->find($value);
        if (!($client instanceof Client)) {
            throw new TransformationFailedException();
        }

        return $client;
    }
}
