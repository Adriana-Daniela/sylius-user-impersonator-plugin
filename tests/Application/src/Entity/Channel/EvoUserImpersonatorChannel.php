<?php
declare(strict_types=1);

namespace Tests\Adriana\SyliusUserImpersonatorPlugin\Application\src\Entity\Channel;

use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelInterface;
use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

class EvoUserImpersonatorChannel extends BaseChannel implements EvoUserImpersonatorChannelInterface
{
    use EvoUserImpersonatorChannelTrait;
}
