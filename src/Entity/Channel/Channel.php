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
    protected bool $showUserImpersonateHint = true;

    /**
     * @return bool
     */
    public function isShowUserImpersonateHint(): bool
    {
        return $this->showUserImpersonateHint;
    }

    /**
     * @param bool $showUserImpersonateHint
     */
    public function setShowUserImpersonateHint(bool $showUserImpersonateHint): void
    {
        $this->showUserImpersonateHint = $showUserImpersonateHint;
    }
}
