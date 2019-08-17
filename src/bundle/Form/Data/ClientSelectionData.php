<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Form\Data;

final class ClientSelectionData
{
    /** @var \Trikoder\Bundle\OAuth2Bundle\Model\Client[]|null */
    private $selection;

    public function __construct(?array $selection = null)
    {
        $this->setSelection($selection);
    }

    /**
     * @return \Trikoder\Bundle\OAuth2Bundle\Model\Client[]
     */
    public function getSelection(): array
    {
        return $this->selection;
    }

    /**
     * @param \Trikoder\Bundle\OAuth2Bundle\Model\Client[]|null $selection
     */
    public function setSelection(?array $selection): void
    {
        if ($selection === null) {
            $this->selection = [];
        }

        $this->selection = [];
        foreach ($selection as $client) {
            $this->selection[$client->getIdentifier()] = $client;
        }
    }
}
