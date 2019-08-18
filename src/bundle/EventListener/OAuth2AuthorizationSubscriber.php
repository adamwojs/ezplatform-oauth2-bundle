<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\AuthorizationRequestResolveEvent;
use Trikoder\Bundle\OAuth2Bundle\OAuth2Events;

final class OAuth2AuthorizationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            OAuth2Events::AUTHORIZATION_REQUEST_RESOLVE => 'onAuthorizationRequestResolve',
        ];
    }

    public function onAuthorizationRequestResolve(AuthorizationRequestResolveEvent $event): void
    {
        $event->resolveAuthorization(true);
    }
}
