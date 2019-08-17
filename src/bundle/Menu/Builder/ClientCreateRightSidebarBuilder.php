<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Menu\Builder;

use EzSystems\EzPlatformAdminUi\Menu\AbstractBuilder;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Knp\Menu\ItemInterface;

final class ClientCreateRightSidebarBuilder extends AbstractBuilder implements TranslationContainerInterface
{
    public const EVENT_NAME = 'ezplatform_oauth2.menu_configure.client.create_sidebar_right';

    public const ITEM__CREATE = 'oauth2_client_create__sidebar_right__create';
    public const ITEM__CANCEL = 'oauth2_client_create__sidebar_right__cancel';

    protected function getConfigureEventName(): string
    {
        return self::EVENT_NAME;
    }

    protected function createStructure(array $options): ItemInterface
    {
        /** @var ItemInterface|ItemInterface[] $menu */
        $menu = $this->factory->createItem('root');
        $menu->setChildren([
            self::ITEM__CREATE => $this->createMenuItem(
                self::ITEM__CREATE,
                [
                    'attributes' => [
                        'class' => 'btn--trigger',
                        'data-click' => $options['submit_selector'],
                    ],
                    'extras' => [
                        'icon' => 'publish',
                    ],
                ]
            ),
            self::ITEM__CANCEL => $this->createMenuItem(
                self::ITEM__CANCEL,
                [
                    'route' => 'ezplatform.oauth2.client.list',
                    'extras' => [
                        'icon' => 'circle-close',
                    ],
                ]
            ),
        ]);

        return $menu;
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM__CREATE, 'menu'))->setDesc('Create'),
            (new Message(self::ITEM__CANCEL, 'menu'))->setDesc('Discard changes'),
        ];
    }
}
