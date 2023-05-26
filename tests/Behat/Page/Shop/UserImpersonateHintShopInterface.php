<?php
declare(strict_types=1);

namespace Tests\Adriana\SyliusUserImpersonatorPlugin\Behat\Page\Shop;

interface UserImpersonateHintShopInterface
{
    public function isUserImpersonateHintShown(?string $adminUsername = null): bool;
}
