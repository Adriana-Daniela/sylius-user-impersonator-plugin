<?php
declare(strict_types=1);

namespace Tests\Evo\SyliusUserImpersonatorPlugin\Behat\Page\Shop;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class UserImpersonateShopCheckoutPage extends SymfonyPage implements UserImpersonateHintShopInterface
{
    public function getUserImpersonateHint(): string
    {
        try {
            $userImpersonateHint = $this->getElement('userImpersonateHint');
        } catch (ElementNotFoundException $exception) {
            return '';
        }

        return str_contains($userImpersonateHint->getText(), 'Impersonated by') ? $userImpersonateHint->getText() : '';
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
