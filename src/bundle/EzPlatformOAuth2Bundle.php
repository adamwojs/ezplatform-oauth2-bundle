<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle;

use AdamWojs\EzPlatformOAuth2Bundle\DependencyInjection\CompilerPass\CollectConfiguredScopesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class EzPlatformOAuth2Bundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CollectConfiguredScopesPass());
    }
}
