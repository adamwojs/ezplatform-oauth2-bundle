<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Menu\Listener;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use EzSystems\EzPlatformAdminUi\Menu\MainMenuBuilder;
use EzSystems\EzPlatformAdminUi\Menu\MenuItemFactory;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

final class ConfigureMainMenuListener implements TranslationContainerInterface
{
    public const ITEM_ADMIN__OAUTH2 = 'main__admin__oauth2';

    /** @var \EzSystems\EzPlatformAdminUi\Menu\MenuItemFactory */
    private $menuItemFactory;

    public function __construct(MenuItemFactory $menuItemFactory)
    {
        $this->menuItemFactory = $menuItemFactory;
    }

    public function onMenuConfigure(ConfigureMenuEvent $event): void
    {
        $root = $event->getMenu();
        $root->getChild(MainMenuBuilder::ITEM_ADMIN)->addChild(
            $this->menuItemFactory->createItem(
                self::ITEM_ADMIN__OAUTH2,
                [
                    'route' => 'ezplatform.oauth2.client.list',
                    'extras' => [
                        'routes' => [
                            'ezplatform.oauth2.client.create',
                            'ezplatform.oauth2.client.update',
                        ],
                    ],
                ]
            )
        );
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_ADMIN__OAUTH2, 'menu'))->setDesc('OAuth2'),
        ];
    }
}
