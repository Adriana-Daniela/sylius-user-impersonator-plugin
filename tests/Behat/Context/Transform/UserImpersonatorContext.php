<?php
declare(strict_types=1);

namespace Tests\Evo\SyliusUserImpersonatorPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;

class UserImpersonatorContext implements Context
{
    /**
     * @Transform /^(enabled|disabled)$/
     */
    public function getUserImpersonateHintFlag(string $flag): bool
    {
        return $flag === "enabled";
    }
}
