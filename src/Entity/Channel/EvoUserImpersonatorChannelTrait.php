<?php declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Entity\Channel;

use Doctrine\ORM\Mapping\Column;

trait EvoUserImpersonatorChannelTrait
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
    public function getShowUserImpersonateHint(): bool
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
