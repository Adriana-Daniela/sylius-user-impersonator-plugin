<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Entity\Channel;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\Channel as BaseChannel;

#[Entity]
#[Table(name: "sylius_channel")]
class Channel extends BaseChannel
{
    #[Column(
        name: "show_user_impersonate_hint",
        type: "boolean",
        options: ["default" => 1]
    )]
    protected bool $userImpersonate = true;

    /**
     * @return bool
     */
    public function isUserImpersonate(): bool
    {
        return $this->userImpersonate;
    }

    /**
     * @param bool $userImpersonate
     */
    public function setUserImpersonate(bool $userImpersonate): void
    {
        $this->userImpersonate = $userImpersonate;
    }
}
