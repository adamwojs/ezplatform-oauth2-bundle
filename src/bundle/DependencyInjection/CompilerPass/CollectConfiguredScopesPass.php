<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Workaround for missing \Trikoder\Bundle\OAuth2Bundle\Manager\ScopeManagerInterface::list method.
 */
final class CollectConfiguredScopesPass implements CompilerPassInterface
{
    private const OAUTH2_EXTENSION_NAME = 'trikoder_oauth2';

    public function process(ContainerBuilder $container)
    {
        if ($container->hasExtension(self::OAUTH2_EXTENSION_NAME)) {
            $scopes = $this->getAvailableScopes(
                $container->getExtensionConfig(self::OAUTH2_EXTENSION_NAME)
            );

            $container->setParameter('ezplatform.oauth2.scopes', $scopes);
        }
    }

    private function getAvailableScopes(array $configs): array
    {
        $scopes = [];

        foreach ($configs as $config) {
            if (isset($config['scopes'])) {
                foreach ($config['scopes'] as $scope) {
                    $scopes[] = $scope;
                }
            }
        }

        return array_unique($scopes);
    }
}
