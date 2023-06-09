<?php

declare(strict_types = 1);

namespace Tests\Adriana\SyliusUserImpersonatorPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Doctrine\Persistence\ObjectManager;
use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelInterface;
use Tests\Adriana\SyliusUserImpersonatorPlugin\Behat\Page\Shop\UserImpersonateShopCheckoutPage;
use Tests\Adriana\SyliusUserImpersonatorPlugin\Behat\Page\Shop\UserImpersonateShopHomePage;
use Webmozart\Assert\Assert;

final class UserImpersonatorContext implements Context
{
    public const USER_IMPERSONATOR_STRING = 'Impersonated by ';

    public function __construct(
        private ObjectManager $channelManager,
        private UserImpersonateShopHomePage $userImpersonateShopHomePage,
        private UserImpersonateShopCheckoutPage $userImpersonateShopCheckoutPage
    ) {
    }

    /**
     * @When Channel :channel has show user impersonate hint :flag
     */
    public function channelHasShowUserImpersonateHint(EvoUserImpersonatorChannelInterface $channel, bool $flag): void
    {
        $channel->setShowUserImpersonateHint($flag);

        $this->channelManager->flush();
    }

    /**
     * @Then I should see the impersonated user hint by :adminUsername
     */
    public function thenIShouldSeeTheImpersonatedUserHint(string $adminUsername): void
    {
        Assert::true($this->userImpersonateShopHomePage->isUserImpersonateHintShown($adminUsername));
    }

    /**
     * @Then I should not see the impersonated user hint
     */
    public function thenIShouldNotSeeTheImpersonatedUserHint(): void
    {
        Assert::false($this->userImpersonateShopHomePage->isUserImpersonateHintShown());
    }

    /**
     * @Then I should see the user impersonated hint by :adminUsername on the checkout page
     */
    public function thenIShouldSeeTheUserImpersonatedHintOnTheCheckoutPage(string $adminUsername): void
    {
        Assert::true($this->userImpersonateShopCheckoutPage->isUserImpersonateHintShown($adminUsername));
    }

    /**
     * @Then I should not see the user impersonated hint on the checkout page
     */
    public function thenIShouldNotSeeTheUserImpersonatedHintOnTheCheckoutPage(): void
    {
        Assert::false($this->userImpersonateShopCheckoutPage->isUserImpersonateHintShown());
    }
}
