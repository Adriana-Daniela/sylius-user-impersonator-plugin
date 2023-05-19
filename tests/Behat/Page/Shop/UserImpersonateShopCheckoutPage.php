<?php
declare(strict_types=1);

namespace Tests\Evo\SyliusUserImpersonatorPlugin\Behat\Page\Shop;

use Behat\Mink\Exception\ElementNotFoundException;
use Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonator;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class UserImpersonateShopCheckoutPage extends SymfonyPage implements UserImpersonateHintShopInterface
{
    public function isUserImpersonateHintShown(?string $adminUsername = null): bool
    {
        if ($adminUsername === null) {
            return false;
        }

        try {
            $userImpersonateHintElement = $this->getElement('userImpersonateHint');
        } catch (ElementNotFoundException $exception) {
            return false;
        }

        $userImpersonateHint = CheckUserImpersonator::USER_IMPERSONATOR_STRING . $adminUsername;

        return str_contains($userImpersonateHintElement->getText(), $userImpersonateHint);
    }

    public function getRouteName(): string
    {
        return 'sylius_shop_checkout_address';
    }

    public function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'userImpersonateHint' => '#purchaser-email',
        ]);
    }
}
