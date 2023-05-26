<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Entity\Channel;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel')]
class Channel extends BaseChannel implements EvoUserImpersonatorChannelInterface
{
    use EvoUserImpersonatorChannelTrait;
}
