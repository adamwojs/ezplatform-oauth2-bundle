<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Data;

use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;
use Trikoder\Bundle\OAuth2Bundle\Model\RedirectUri;
use Trikoder\Bundle\OAuth2Bundle\Model\Scope;

final class ClientData
{
    /** @var string|null */
    private $identifier;

    /** @var string|null */
    private $secret;

    /** @var string[] */
    private $redirectUris = [
        'https://',
    ];

    /** @var string[] */
    private $grants = [];

    /** @var string[] */
    private $scopes = [];

    /** @var bool */
    private $active = true;

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    public function getRedirectUris(): array
    {
        return $this->redirectUris;
    }

    public function setRedirectUris(array $redirectUris): void
    {
        $this->redirectUris = $redirectUris;
    }

    public function getGrants(): array
    {
        return $this->grants;
    }

    public function setGrants(array $grants): void
    {
        $this->grants = $grants;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function toModel(): Client
    {
        $model = new Client($this->identifier, $this->secret);
        $model->setActive($this->isActive());

        $model->setRedirectUris(...array_map(function (string $redirectUri): RedirectUri {
            return new RedirectUri($redirectUri);
        }, $this->getRedirectUris()));

        $model->setGrants(...array_map(function (string $grant): Grant {
            return new Grant($grant);
        }, $this->getGrants()));

        $model->setScopes(...array_map(function (string $scope): Scope {
            return new Scope($scope);
        }, $this->getScopes()));

        return $model;
    }

    public static function createFromModel(Client $client): self
    {
        $data = new self();
        $data->setIdentifier($client->getIdentifier());
        $data->setSecret($client->getSecret());
        $data->setActive($client->isActive());

        $data->setRedirectUris(array_map(function (RedirectUri $redirectUri): string {
            return (string)$redirectUri;
        }, $client->getRedirectUris()));

        $data->setGrants(array_map(function (Grant $grant): string {
            return (string)$grant;
        }, $client->getGrants()));

        $data->setScopes(array_map(function (Scope $scope): string {
            return (string)$scope;
        }, $client->getScopes()));

        return $data;
    }
}
