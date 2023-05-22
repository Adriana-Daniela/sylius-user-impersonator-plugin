<?php
declare(strict_types=1);

namespace Tests\Evo\SyliusUserImpersonatorPlugin\Application\src\Entity\Channel;

use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\ChannelInterface;
use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

class Channel extends BaseChannel implements ChannelInterface
{
    use EvoUserImpersonatorChannelTrait;
}
