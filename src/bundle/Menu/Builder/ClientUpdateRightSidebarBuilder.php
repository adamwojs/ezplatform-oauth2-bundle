<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Menu\Builder;

use EzSystems\EzPlatformAdminUi\Menu\AbstractBuilder;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Knp\Menu\ItemInterface;

final class ClientUpdateRightSidebarBuilder extends AbstractBuilder implements TranslationContainerInterface
{
    public const EVENT_NAME = 'ezplatform_oauth2.menu_configure.client.update_sidebar_right';

    public const ITEM__SAVE = 'oauth2_client_update__sidebar_right__save';
    public const ITEM__CANCEL = 'oauth2_client_update__sidebar_right__cancel';

    protected function getConfigureEventName(): string
    {
        return self::EVENT_NAME;
    }

    protected function createStructure(array $options): ItemInterface
    {
        /** @var ItemInterface|ItemInterface[] $menu */
        $menu = $this->factory->createItem('root');
        $menu->setChildren([
            self::ITEM__SAVE => $this->createMenuItem(
                self::ITEM__SAVE,
                [
                    'attributes' => [
                        'class' => 'btn--trigger',
                        'data-click' => $options['submit_selector'],
                    ],
                    'extras' => [
                        'icon' => 'save',
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
            (new Message(self::ITEM__SAVE, 'menu'))->setDesc('Save'),
            (new Message(self::ITEM__CANCEL, 'menu'))->setDesc('Discard changes'),
        ];
    }
}
