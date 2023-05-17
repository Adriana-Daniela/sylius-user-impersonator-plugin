<?php

declare(strict_types=1);

namespace Tests\Evo\SyliusUserImpersonatorPlugin\Behat\Page\Shop;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class UserImpersonateShopHomePage extends SymfonyPage implements UserImpersonateHintShopInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserImpersonateHint(): string
    {
        try {
            $userImpersonateHint = $this->getElement('userImpersonateHint');
        } catch (ElementNotFoundException $exception) {
            return '';
        }
        return $userImpersonateHint->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_shop_homepage';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'userImpersonateHint' => '.user-impersonate-hint',
        ]);
    }
}
