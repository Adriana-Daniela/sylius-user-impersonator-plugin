<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Service;

use Evo\SyliusUserImpersonatorPlugin\Exception\UserNotFoundException;
use Sylius\Component\Core\Model\AdminUser;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CheckUserImpersonatorService
{
    protected const SECURITY_ADMIN_TOKEN_NAME = '_security_admin';
    protected const SYLIUS_IMPERSONATED_USER = 'sylius_impersonated_user';

    public function __construct(private RequestStack $requestStack, private Security $security)
    {
    }

    /**
     * @psalm-suppress UnusedVariable
     */
    public function fetchImpersonatedUser(): UserInterface
    {
        $userImpersonator = $this->fetchUsernamePasswordToken();

        if ($userImpersonator?->getUser() === null) {
            throw new UserNotFoundException('Expected logged in user');
        }

        /** @psalm-ignore-nullable-return */
        return $userImpersonator->getUser();
    }

    public function isImpersonated(): bool
    {
        if ($this->security->getUser() === null) {
            return false;
        }

        if (!$this->requestStack->getSession()->has(static::SYLIUS_IMPERSONATED_USER)) {
            return false;
        }

        return (bool) $this->requestStack->getSession()->get(static::SYLIUS_IMPERSONATED_USER);
    }

    public function fetchUsernamePasswordToken(): ?UsernamePasswordToken
    {
        /** @psalm-param string $usernamePasswordToken */
        $usernamePasswordToken = $this->requestStack->getSession()->get(static::SECURITY_ADMIN_TOKEN_NAME);

        if ($usernamePasswordToken === null) {
            return null;
        }

        /** @var UsernamePasswordToken $userImpersonator */
        $userImpersonator = unserialize($usernamePasswordToken, ['allowed_classes' => [UsernamePasswordToken::class, AdminUser::class]]);

        return $userImpersonator;
    }
}
