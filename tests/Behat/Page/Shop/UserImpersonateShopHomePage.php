<?php

declare(strict_types=1);

namespace Tests\Evo\SyliusUserImpersonatorPlugin\Behat\Page\Shop;

use Behat\Mink\Exception\ElementNotFoundException;
use Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonator;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class UserImpersonateShopHomePage extends SymfonyPage implements UserImpersonateHintShopInterface
{
    /**
     * {@inheritdoc}
     */
    public function isUserImpersonateHintShown(?string $adminUsername = null): bool
    {
        if ($adminUsername === null) {
            return false;
        }

        try {
            $userImpersonateHint = $this->getElement('userImpersonateHint');
        } catch (ElementNotFoundException $exception) {
            return false;
        }

        return str_contains($userImpersonateHint->getText(), CheckUserImpersonator::USER_IMPERSONATOR_STRING . $adminUsername);
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
