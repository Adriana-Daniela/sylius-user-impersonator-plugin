<?php

declare(strict_types = 1);

namespace Tests\Adriana\SyliusUserImpersonatorPlugin\Application\Entity\Channel;

use Doctrine\ORM\Mapping as ORM;
use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel')]
class Channel extends BaseChannel
{
    use EvoUserImpersonatorChannelTrait;
}
