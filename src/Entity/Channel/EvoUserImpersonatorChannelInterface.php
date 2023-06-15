<?php

declare(strict_types = 1);

namespace Evo\SyliusUserImpersonatorPlugin\Entity\Channel;

use Sylius\Component\Channel\Model\ChannelInterface as BaseChannelInterface;

interface EvoUserImpersonatorChannelInterface extends BaseChannelInterface
{
    /**
     * @return bool
     */
    public function getShowUserImpersonateHint(): bool;

    /**
     * @param bool $showUserImpersonateHint
     *
     * @return void
     */
    public function setShowUserImpersonateHint(bool $showUserImpersonateHint): void;
}
